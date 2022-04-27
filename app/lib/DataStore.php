<?php

namespace Lib;

require_once '/var/www/html/vendor/autoload.php';

use MongoDB\BSON\Regex;
use MongoDB\Client;
use Lib\TwitterTools;

class DataStore
{
    static $connection;

    static $db = 'fatima';

    static private function connect()
    {
        if (!self::$connection) {
            self::$connection = new Client('mongodb://root:MongoDB2019!@mongo:27017');
            self::$connection = self::$connection->{self::$db};
        }

        return self::$connection;
    }


    static public function save($data)
    {
        $collection = self::connect()->data;
        $data->created = new \MongoDB\BSON\UTCDateTime();
        $data->updated = new \MongoDB\BSON\UTCDateTime();

        $return = $collection->insertOne($data);

        return $return;
    }

    static public function updateOrSaveById($id, $data)
    {
        $collection = self::connect()->data;

        $query = array(
            'id' => $id
        );

        $exists = $collection->findOne($query);

        if ($exists) {
            echo 'updating: ' . json_encode($data) . PHP_EOL;
            $data->updated = new \MongoDB\BSON\UTCDateTime();
            self::updateById($id, $data);
        } else {
            echo 'creating new: ' . json_encode($data) . PHP_EOL;
            self::save($data);
            self::sendTweet($data);
        }
    }

    static public function get($page = 1, $sort = 'signingDateParsed', $limit = 9, $order = -1)
    {
        $collection = self::connect()->data;

        $skip = $page === 1 ? 0 : $page * $limit;

        $options = array(
            'sort' => array(
                $sort => $order
            ),
            'limit' => $limit,
            'skip' => $skip
        );

        return $collection->find([], $options);
    }

    static public function getLastLocations()
    {
        /*
         *
         *
         * db.data.aggregate([
  { "$group": {
    "_id": "$message.from.username",
    "doc": { "$last": "$$ROOT" }
  }},
  { "$replaceRoot": {
    "newRoot": "$doc"
  }}
])
         *
         *
         *
         */

        $collection = self::connect()->data;

        $pipeline = array(
            array(
                '$group' => [
                    '_id' => '$message.from.username',
                    'doc' => [ '$last' => '$$ROOT']
                ],
            ),
            array(
                '$replaceRoot' => [
                    'newRoot' => '$doc'
                ]
            )
        );


        return $collection->aggregate($pipeline)->toArray();
    }
}
