<?php
/**
 * @author Muhamad Rifki <rifki@rikilabs.net>
 * Get Youtube ID and displaying thumbnail
 * @version 1.0.0
 */
class YoutubeID
{
    /**
     * Validate URL
     * @param $url
     * @return bool
     */
    public static function validateUrl($url)
    {
        if (parse_url($url, PHP_URL_SCHEME)) {
            return true;
        }
        return false;
    }

    /**
     * get thumbnail video
     * @param $id
     * @param $thumb
     * @param string $size
     * @return bool
     */
    public static function thumbImg($id, $thumb=1, $size='small')
    {
        if ($id != "" && $thumb !="") {
            if ($thumb > 4 || $thumb < 1) {
                return false;
            }

            if (self::validID($id) !== false) {
                $id_value = $id;
            } else {
                $id_value = self::getVideoID($id);
            }

            if ($size == strtolower('small')) {
                $images = array(
                    0 =>'http://img.youtube.com/vi/'.$id_value.'/0.jpg',
                    1 =>'http://img.youtube.com/vi/'.$id_value.'/1.jpg',
                    2 =>'http://img.youtube.com/vi/'.$id_value.'/2.jpg',
                    3 =>'http://img.youtube.com/vi/'.$id_value.'/3.jpg'
                );
            } elseif ($size == strtolower('large')) {
                $images = array(
                    0 =>'http://i1.ytimg.com/vi/'.$id_value.'/default.jpg',
                    1 =>'http://i1.ytimg.com/vi/'.$id_value.'/mqdefault.jpg',
                    2 =>'http://i1.ytimg.com/vi/'.$id_value.'/hqdefault.jpg',
                    3 =>'http://i1.ytimg.com/vi/'.$id_value.'/sddefault.jpg'
                );
            } else {
                return $size;
            }

            return $images[$thumb];
        }
    }

    /**
     * Get video ID
     * @param $url
     * @return bool
     */
    public static function videoID($url)
    {
        $id = self::validID($url);
        if ($id) {
            return self::getVideoID($id);
        }
        return false;
    }

    /**
     * Get Video ID FROM Youtube URL
     * @param $url
     * @return bool
     */
    public static function getVideoID($url)
    {
        if (self::validateUrl($url)) {
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
     * @param Youtube id $id
     * @param YouTube API v2.0 string $y_version
     */
    public static function validID($id, $y_version='2')
    {
        $header = get_headers('http://gdata.youtube.com/feeds/api/videos/'.$id.'?v='.$y_version);
        # HTTP/1.0 200 OK
        if (strpos($header[0], 200)) {
            return true;
        }
        return false;
    }
}