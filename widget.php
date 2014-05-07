<?php
    /**
    * The Widget
    */
    class StrangeRssWidget extends WP_Widget {
        /** constructor */
        function StrangeRssWidget() {
            parent::WP_Widget(false, $name = 'Strange News Feed');    
        }

        /** @see WP_Widget::widget */
        function widget($args, $instance) {      
            //get arguments
            extract( $args );

            //set title var
            $title = 'Strange News';

            //get title
            if(isset($instance['title']))
                $title = apply_filters('widget_title', $instance['title']);

            //get limit
            $limit = 5;
            if(isset($instance['limit']))
                $limit = $instance['limit'];

            //set amount of words per item to display
            $amount_of_words = 50;

				//get hide_description
            $show_thumbnail = 0;
            if(isset($instance['show_thumbnail']))
                $show_thumbnail = $instance['show_thumbnail'];
					 
            //get hide_description
            $hide_description = 0;
            if(isset($instance['hide_description']))
                $hide_description = $instance['hide_description'];

            //get show_date
            $show_date = 0;
            if(isset($instance['show_date']))
                $show_date = $instance['show_date'];

            echo $before_widget; 

            if ( $title )
                echo $before_title . $title . $after_title;

            $i = 0;

				$url = html_entity_decode('http://gloomwire.com/feeds/most-read/');

            //test feed first
            $content = @file_get_contents($url); 
            try { 
                $xml = new SimpleXmlElement($content);
				 } catch(
                Exception $e){ 
                /* the data provided is not valid XML */ 
                return 'News feed could not load.'; 
                exit();
            }

           	$return  = StrangeRssParse($xml,$limit,$show_thumbnail,$hide_description,$show_date);
            echo $return;
            echo $after_widget;

        }

        /** @see WP_Widget::update */
        function update($new_instance, $old_instance) {                
            $instance = $old_instance;
            $instance['limit'] = (int)($new_instance['limit']);
            $instance['title'] = strip_tags($new_instance['title']);
				$instance['show_thumbnail'] = (int)($new_instance['show_thumbnail']);
            $instance['hide_description'] = (int)($new_instance['hide_description']);
            $instance['show_date'] = (int)($new_instance['show_date']);
            return $instance;
        }

        /** @see WP_Widget::form */
        function form($instance) {                
            if(isset( $instance['title'] ))
                $title = esc_attr($instance['title']);
            else $title = '';

            if(isset( $instance['limit'] ))
                $limit = (int)($instance['limit']);
            else $limit = 5;

            $url = 'http://gloomwire.com/feeds/most-read/';
				
				if(isset( $instance['show_thumbnail'] ))
                $show_thumbnail = (int)($instance['show_thumbnail']);
            else $show_thumbnail = 0;

            if(isset( $instance['hide_description'] ))
                $hide_description = (int)($instance['hide_description']);
            else $hide_description = 0;
            
            if(isset( $instance['show_date'] ))
                $show_date = (int)($instance['show_date']);
            else $show_date = 0;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>

            <br />
            <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('No# messages:'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>

            <br />
				<label for="<?php echo $this->get_field_id('show_thumbnail'); ?>"><?php _e('Show Thumbnail:'); ?> &nbsp;
                <input type="checkbox" id="<?php echo $this->get_field_id('show_thumbnail'); ?>" value="1" name="<?php echo $this->get_field_name('show_thumbnail'); ?>" <?php if($show_thumbnail == 1) echo 'checked="checked"'; ?> /></label>
            
            <br />
            <label for="<?php echo $this->get_field_id('hide_description'); ?>"><?php _e('Hide description:'); ?> &nbsp;
                <input type="checkbox" id="<?php echo $this->get_field_id('hide_description'); ?>" value="1" name="<?php echo $this->get_field_name('hide_description'); ?>" <?php if($hide_description == 1) echo 'checked="checked"'; ?> /></label>
            
            <br />
            <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Show date?'); ?> &nbsp;
                <input type="checkbox" id="<?php echo $this->get_field_id('show_date'); ?>" value="1" name="<?php echo $this->get_field_name('show_date'); ?>" <?php if($show_date == 1) echo 'checked="checked"'; ?> /></label>
        </p>
        <?php 
        }

    }


    add_action('widgets_init', create_function('', 'return register_widget("StrangeRssWidget");'));