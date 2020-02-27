<?php

namespace App\Http\Helpers;

class FeedHelper
{

    /**
     * This function implodes rss feed title and summary to text for count function
     *
     * @param $rss
     * @return array
     */
    public static function getCommonWords($rss)
    {
        //Loops the rss feed and sets to string summary and title and author name since it is in the feed
        foreach ($rss->entry as $item) {
            $arrayOfItems[] = $item->summary . $item->title.$item->author->name;
        }
        return self::extractWords(implode(' ', $arrayOfItems), self::mostCommonWordsArray(), 10);
    }

    /**
     * This function counts words in string
     *
     * @param $string
     * @param $stop_words
     * @param int $max_count
     * @return array
     */
    public static function extractWords($string, $stop_words, $max_count = 5)
    {  //max count to define how many words are returned
        $string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
        $string = trim($string); // trim the string
        $string = strip_tags($string); //strip the tags from string
        $string = strtolower($string); // make it lowercase
        $string = preg_replace('/[^a-zA-Z.\/\&nbsp\;() - ]/', '', $string); // only take alpha characters, but keep the spaces and dashes too… remove / .
        preg_match_all('/\b.*?\b/i', $string, $matchWords);
        $matchWords = $matchWords[0];
        //Loops the words found in the string, not unique, unsets the word from array if it is an empty space or a word that is most commonly used
        foreach ($matchWords as $key => $item) {
            if (trim($item) == '' || in_array($item, $stop_words) || strlen($item) <= 3) {
                unset($matchWords[$key]);
            }
        }
        $wordCountArr = array();
        //If exists a string
        if (is_array($matchWords)) {
            //goes through string and adds count to key if key found or sets a key with count of one
            foreach ($matchWords as $key => $val) {
                $val = strtolower($val);
                if (isset($wordCountArr[$val])) {
                    $wordCountArr[$val]++;
                } else {
                    $wordCountArr[$val] = 1;
                }
            }
        }
        //Sort the array by highest number
        arsort($wordCountArr);
        //Returns first results of a how much is needed
        $wordCountArr = array_slice($wordCountArr, 0, $max_count);
        return $wordCountArr;
    }

    /**
     * Returns array of most 50 common words in english
     * @return array
     */
    public static function mostCommonWordsArray()
    {
        $c = curl_init(env('COMMON_WORDS_TABLE','https://en.wikipedia.org/wiki/Most_common_words_in_English'));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($c);
        curl_close($c);
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $dom->preserveWhiteSpace = false;
        $tables = $dom->getElementsByTagName('table');

        $topCommonWordTable = $tables->item(0);
        $topWordsArray = [];
        $count = 0;
        foreach ($topCommonWordTable->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');
            if($tds->length > 0) {
                if ($count < 50) {
                    $topWordsArray[] = $tds->item(0)->nodeValue;
                }
                $count++;
            }
        }
        return $topWordsArray;
    }

}
