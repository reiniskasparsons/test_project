<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{

    /**
     * Gets the RSS feed from the url
     *
     * @return array
     */
    public function getFeed()
    {
        return simplexml_load_file('https://www.theregister.co.uk/software/headlines.atom');
    }

    /**
     * This function implodes rss feed title and summary to text for count function
     *
     * @param $rss
     * @return array
     */
    public function getCommonWords($rss)
    {
        //Loops the rss feed and sets to string summary and title and author name since it is in the feed
        foreach ($rss->entry as $item) {
            $arrayOfItems[] = $item->summary . $item->title.$item->author->name;
        }
        //implodes the array to string
        $string = implode(' ', $arrayOfItems);

        return $this->extractWords(implode(' ', $arrayOfItems), $this->mostCommonWordsArray(), 10);
    }

    /**
     * This function counts words in string
     *
     * @param $string
     * @param $stop_words
     * @param int $max_count
     * @return array
     */
    public function extractWords($string, $stop_words, $max_count = 5)
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
    public function mostCommonWordsArray()
    {
        return ['the', 'be', 'to', 'of', 'and', 'a', 'in', 'that', 'have', 'I', 'it', 'for', 'not', 'on', 'with', 'he', 'as', 'you', 'do', 'at', 'this', 'but', 'his', 'by', 'from', 'they', 'we', 'say', 'her', 'she', 'or', 'an', 'will', 'my', 'one', 'all', 'would', 'there', 'their', 'what', 'so', 'up', 'out', 'if', 'about', 'who', 'get', 'which', 'go', 'me'];
    }
}
