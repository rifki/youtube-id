<?php
/**
 * @author Muhamad Rifki <rifki@rikilabs.net>
 * Get Youtube ID and displaying thumbnail
 * @version 1.0.1
 */
class YoutubeID
{
    /**
     * Get thumbnail image 
     * @param $id
     * @param int $thumb(0,1,2,3)
     * @param string $size
     * @return bool
     */
    public static function getThumbs($id, $size='medium')
    {
        if (isset($id)) {
            if (self::isValidID($id)) {
                $id = self::isValidID($id);
            }

            switch (strtolower($size)) {
                case 'medium':
                    $images = 'http://i1.ytimg.com/vi/'.$id.'/mqdefault.jpg';
                    break;
                case 'large':
                    $images = 'http://i1.ytimg.com/vi/'.$id.'/hqdefault.jpg';
                    break;
                case 'extra':
                    $images = 'http://i1.ytimg.com/vi/'.$id.'/sddefault.jpg';
                    break;
                default: $images = '';
            }

            return $images;
        }
    }

    /**
     * Get Video ID
     * @param $url
     * @return bool
     */
    public static function getVideoID($url)
    {
        if (self::isValidURL($url)) {
            $part = parse_url($url);
            if ( strpos($url, trim('youtube')) ) {
                if ( strpos($url, 'v=') ) {
                    return substr( $part['query'],  strpos($part['query'], 'v=') + 2, 11 );
                }
                elseif ( strpos($url, '/v/') ) {
                    return substr( $part['path'], strpos($part['path'], '/v/') + 3 , 11 );
                }
                elseif ( strpos($url, '/vi/') ) {
                    return substr( $part['path'], strpos($part['path'], '/vi/') + 4, 11 );
                }
                elseif ( strpos($url, trim('youtu.be') ) || strpos($url, trim('www.youtu.be')) ) {
                    if (strpos($url, '/'))
                        return substr( $part['path'], strpos($part['path'], '/') + 1, 11 );
                }
                elseif (strpos($url, '/embed/')) {
                    return substr( $part['path'], strpos($part['path'], '/embed/') + 7, 11);
                }
                else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    /**
     * Get Youtube embed
     *
     * @param string Youtube id
     * @param int width
     * @param int height
     * @param boolean old embed (flash/iframe)
     * @param boolean suggested video
     * @param boolean privacy mode
     * @return string generate code
     */
    public static function getEmbed($id, $width='', $height='', $old_embed=false, $sugested=false, $privacy_mode=true) 
    {
        if (isset($id)) {
            if (self::isValidID($id)) {
                $id = self::isValidID($id);
            }

            // Only support Flash.
            if ($old_embed) {
                $embed = '<object width="'.$width.'" height="'.$height.'">';
                //Show suggested videos when the video finishes
                $sugested = ($sugested === true ? '&amp;rel=0' : '');
                //Enabling this option means that YouTube won’t store information about visitors on your web page unless they play the video.
                $privacy_mode = ($privacy_mode === true ? '//www.youtube-nocookie.com/v/' : '//www.youtube.com/v/');

                if ($privacy_mode) {
                    $embed .= '<param name="movie" value="'.$privacy_mode.$id.'"?version=3&amp;hl=en_US'.$sugested;
                }
                else {
                    $embed .= '<param name="movie" value="'.$privacy_mode.$id.'"?version=3&amp;hl=en_US'.$sugested;
                }

                $embed .= '<param name="allowFullScreen" value="true"></param>';
                $embed .= '<param name="allowscriptaccess" value="always"></param>';
                $embed .= '<embed src="'.$privacy_mode.$id.'"?version=3&amp;hl=en_US"'.$sugested.'" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" allowscriptaccess="always" allowfullscreen="true"></embed>';
                $embed .= '</object>';
            }
            //supports both Flash and HTML5 video
            else {
                $embed = '<iframe width="'.$width.'" height="'.$height.'" ';
                //Show suggested videos when the video finishes
                $sugested = ($sugested === true ? '&rel=0' : '');
                //Enabling this option means that YouTube won’t store information about visitors on your web page unless they play the video.
                $privacy_mode = ($privacy_mode === true ? '//www.youtube-nocookie.com/embed/' : '//www.youtube.com/embed/');

                if ($privacy_mode) {
                    $embed .= 'src="'.$privacy_mode.$id.'" frameborder="0" allowfullscreen></iframe>';
                }
                else {
                    $embed .= 'src="'.$privacy_mode.$id.'" frameborder="0" allowfullscreen></iframe>';
                }
            }

            return $embed;
        }
    }

    /**
     * Validate URL
     * @param string $url
     * @return bool
     */
    public static function isValidURL($url)
    {
        if (parse_url($url, PHP_URL_SCHEME)) {
            return true;
        }
        return false;
    }

    /**
     * Validate Video ID
     * @param Youtube id string $id
     */
    public static function isValidID($id)
    {
        $header = get_headers('http://gdata.youtube.com/feeds/api/videos/'.$id);
        # HTTP/1.0 200 OK
        if (strpos($header[0], 200)) {
            return true;
        }
        return false;
    }
}
