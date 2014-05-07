<?php 
    function rss_feed_reader($limit=10,$show_thumbnail=0,$hide_description=0,$show_date=0){
        $url = html_entity_decode('http://gloomwire.com/feeds/most-read/');

        //test feed first
        $content = @file_get_contents($url); 
        try { 
            $xml = new SimpleXmlElement($content); 
        }   catch (
            Exception $e){ 
            /* the data provided is not valid XML */ 
            return 'Unfortunally the feed you provided is not valid...'; 
            exit();
        }
        
        if(!is_object($xml)){ return 'Unfortunally the feed you provided is not valid...';  }
        
        $return  = StrangeRssParse($xml,$limit,$hide_description,$show_date);
        
        return $return;
    }


    /**
    * Include the shortscriptfunctions for rss
    * 
    * enables:
    * [simple-rss feed="http://www.xxx.feed"]
    * 
    */
    function rss_feed_shorttag($atts) {
        extract(shortcode_atts(array(
                    'hide_description'  => 0,
                    'show_date'  => 0,
                    'show_thumbnail'   => 0,
                    'limit'             => ''
                ), $atts));

        return rss_feed_reader($limit,$show_thumbnail,$hide_description,$show_date);
    }
    //add shortcodes
    add_shortcode( 'strange-news-feed', 'rss_feed_shorttag');