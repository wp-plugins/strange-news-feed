<?php
    /**
    * turn feed into html
    * 
    * @param mixed $xml
    * @param mixed $limit
    * @param mixed $amount_of_words
    */
    function StrangeRssParse($xml,$limit=10,$show_thumbnail,$hide_description=0,$show_date=0){
		 
        $return .= "<ul class=\"strange-rss-list\">";
        $i=0;
        
        foreach($xml->channel->item as $item) 
        { 
            $i++;
            
            $titel  = $item->title; 
            $link   = $item->link; 
            $date   = '';
            if(!empty($item->pubDate)){
                $date   = date('F d, Y ',strtotime($item->pubDate)); 
            }

            $return .= '<li class="strange-rss-item"><h3><a href="'.$link.'" target="_blank" title="'.($titel).'" rel="nofollow" class="strange-rss-link">'.($titel).'</a></h3>';
            if($show_date == 1 && !empty($date)){
                $return .= '<span class="strange-rss-date">'.$date.'</span>';
            }
            if($hide_description == 0){
                $return .= '<span class="strange-rss-description">'.$item->description.'</span>';
            }
            $return .= '</li>'; 

            if($i == $limit) break;
        } 
        $return .= "</ul>";
        return $return;
    }
