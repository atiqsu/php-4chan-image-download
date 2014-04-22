<?php 
/*
 * Fabrizio Di Pilla 2014
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function getAndDownload( $url ){
    $dom = new domDocument;
    
    $content = file_get_contents($url);
    
    $dom->loadHTML($content);
    
    $dom->preserveWhiteSpace = false;
    
    $links = $dom->getElementsByTagName('a');
    
    
    
    $urls = array();
    
    
    /*
     * Two separated loops, so i can know the total number of images and show a 'progress' message
     */     
    
    foreach ($links as $tag) {
        
        $destination = $tag->getAttribute('href');
        
        if (strpos($destination, 'i.4cdn.org/')){
            
            $urls[] = $destination;
            
        }
        
    }

    
    $totalImages = count($urls);
    $imageCounter = 1;
    
    $folder = explode('/', $url);
    $folder = $folder[count($folder) - 1];
    
    mkdir($folder);
    
    foreach($urls as $url){
        
        print "Downloading {$imageCounter}/{$totalImages}\n";
        
        if (!file_exists($folder . '/' . basename($url))){
            
            file_put_contents($folder . '/' . basename($url), fopen("http:{$url}", 'r'));            
            
        } else {
            
            print basename($url) . " alreadey downloaded.\n";
            
        }
        
        $imageCounter++;
    }
    
    
    
    
}



$param = ( isset($argv[1]) ) ? $argv[1] : $_GET['url'];

if ( !$param ) {
    
    print "Error, no url suplieded.\n";
    print "Usange:\n";
    print "From command line\n";
    print "php -f 4chan.php <url>\n";
    print "Or from url\n";
    print "http://localhost/4chan.php?url=<url>\n";
    
    die();
}


getAndDownload( $param );


?>