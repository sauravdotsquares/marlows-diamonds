<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;

class XMLController extends Controller
{
    public function XMLFunction()
    {
        // Fetch records from database
        $getProductData = Products::with(['getProductImages','getProductGallery','getProductVariation'])->select('*')->latest()->get();
        // return response()->json($getProductData);
        // echo "<pre>";
        // print_r($getProductData->toArray());
        // die;
        $this->createXMLfileNewFormat($getProductData);
        echo "Done";
        // echo "Done<pre>";
        // print_r($getProductData);
        // die;
    }

    // public function createXMLfile($booksArray){
    //     // echo "checking in xml files <pre>";
    //     // print_r($booksArray);
    //     // die;

    //     if (!file_exists(public_path('files/'))) {
    //         mkdir(public_path('files/'), 0777);
    //     }

    //     $filePath = public_path('files/book.xml');

    //     $dom     = new \DOMDocument('1.0', 'utf-8');

    //     $root      = $dom->createElement('books');

    //     for($i=0; $i<count($booksArray); $i++){
    //         // echo "aff<pre>";
    //         // print_r($booksArray[$i]['id']);
    //         // die;

    //       $bookId        =  $booksArray[$i]['id'];

    //       $bookName = htmlspecialchars($booksArray[$i]['title']);

    //       $bookAuthor    =  $booksArray[$i]['author_name'];

    //       $bookPrice     =  $booksArray[$i]['price'];

    //       $bookISBN      =  $booksArray[$i]['ISBN'];

    //       $bookCategory  =  $booksArray[$i]['category'];

    //       $book = $dom->createElement('book');

    //       $book->setAttribute('id', $bookId);

    //       $name     = $dom->createElement('title', $bookName);

    //       $book->appendChild($name);

    //       $author   = $dom->createElement('author', $bookAuthor);

    //       $book->appendChild($author);

    //       $price    = $dom->createElement('price', $bookPrice);

    //       $book->appendChild($price);

    //       $isbn     = $dom->createElement('ISBN', $bookISBN);

    //       $book->appendChild($isbn);

    //       $category = $dom->createElement('category', $bookCategory);

    //       $book->appendChild($category);

    //       $root->appendChild($book);

    //     }

    //     $dom->appendChild($root);

    //     $dom->save($filePath);

    // }

    public function createXMLfileNewFormat($productArray){
        // echo "checking in xml files <pre>";
        // print_r($booksArray);
        // die;

        if (!file_exists(public_path('files/'))) {
            mkdir(public_path('files/'), 0777);
        }

        $filePath = public_path('files/book.xml');

        $dom     = new \DOMDocument('1.0', 'utf-8');

        $root = $dom->createElement('rss');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', 'http://base.google.com/ns/1.0');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:c', 'http://base.google.com/ns/1.0');
        $root->setAttributeNS('', 'version', '2.0');
        $root->setAttributeNS('', 'encoding', 'utf-8');

        $channelNew = $dom->createElement('channel');
        // $xml_a = $xmlObject->createElement('parent');
        // $channel->appendChild($channel);
        // $root->appendChild($channel);

        foreach($productArray as $key => $productArrayNew){


            foreach($productArrayNew->getProductVariation as $var => $dataArray){

                $title = '';
                $metalType = '';
                $price = '';
                $caratType = '';
                $widthType = '';
                $diamondWeight = '';
                $linkQuery = '';
                foreach($dataArray->get_vari_details_id as $key2 => $var2){
                    $var2->key = str_replace("attri_","",$var2->key);
                    if($var2->value){
                        $linkQuery .= $linkQuery ? '&'.$var2->key.'='.$var2->value : $var2->key.'='.$var2->value;
                    }
                    if(isset($var2->key) && $var2->key == 'metal-type'){
                        $metalType .= $var2->value;
                    }

                    if(isset($var2->key) && $var2->key == 'carat'){
                        $caratType .= $var2->value;
                    }

                    if(isset($var2->key) && $var2->key == 'total-diamond-weight'){
                        $diamondWeight .= $var2->value;
                    }

                    if(isset($var2->key) && $var2->key == 'width-mm'){
                        $widthType = $var2->value;
                    }

                    $price = $dataArray->regular_price;
                }


                $productGroupId        =  'ig_'.$productArrayNew->id;
                $productName = htmlspecialchars($productArrayNew->title.' - '.(($caratType!='')?$caratType.' - ':'').(($diamondWeight!='')?$diamondWeight.' - ':'').(($widthType!='')?$widthType.' - ':'').$metalType);

                $productId        =  'p_id_'.md5($productName);



                $productDescription    =  htmlspecialchars(strip_tags($productArrayNew->short_description));
                // $productDescription = str_replace(['<p>', '</p>'], '', $productDescription);

                // echo $productDescription."<pre>";
                // print_r($productDescription);
                // die;

                $productQueryLink=  'https://www.marlows-diamonds.co.uk/product/'.$productArrayNew->slug . ($linkQuery ? '?'.$linkQuery : '');
                $productLink     =  'https://www.marlows-diamonds.co.uk/product/'.$productArrayNew->slug;
                $productImageLink      =  'https://www.marlows-diamonds.co.uk/storage/'.$productArrayNew->getProductImages->image_url;
                $productPrice  =  round($price*1.2);
                // $productSalePrice  =  '';
                // $productSalePriceEffectiveDate  =  '';
                $productCondition  =  'new';
                // $productShippingWeight  =  '1.00 lb';
                $productAvailability  =  'in stock';
                $productIdentifierExists  =  'no';
                // $productAdditionalImageLink  =  'https://mccoyhome.com/media/catalog/product/s/q/squareall6.jpeg';
                $productType  =  $productArrayNew->cat_details;

                $product = $dom->createElement('item');

                $productid  = $dom->createElement('g:id', $productId);
                $product->appendChild($productid);

                $title   = $dom->createElement('g:title', $productName);

                $product->appendChild($title);

                $description   = $dom->createElement('g:description', $productDescription);

                $product->appendChild($description);

                $item_group_id   = $dom->createElement('g:item_group_id', $productGroupId);

                $product->appendChild($item_group_id);

                $link    = $dom->createElement('g:link', htmlentities($productQueryLink));

                $product->appendChild($link);

                $link    = $dom->createElement('g:product_type', $productType);

                $product->appendChild($link);

                // $link    = $dom->createElement('g:google_product_category', '200');

                // $product->appendChild($link);

                $image_link     = $dom->createElement('g:image_link', $productImageLink);

                $product->appendChild($image_link);

                $condition = $dom->createElement('g:condition', $productCondition);

                $product->appendChild($condition);

                $availability = $dom->createElement('g:availability', $productAvailability);

                $product->appendChild($availability);

                $price = $dom->createElement('g:price', $productPrice.' GBP ');

                $product->appendChild($price);

                $price = $dom->createElement('g:brand', 'Marlows Diamonds');

                $product->appendChild($price);

                $price = $dom->createElement('g:canonical_link', $productLink);

                $product->appendChild($price);

                foreach($productArrayNew->getProductGallery as $key => $addImages){
                    $additional_image_link = $dom->createElement('g:additional_image_link', 'https://www.marlows-diamonds.co.uk/storage/'.$addImages->image_url);

                    $product->appendChild($additional_image_link);
                }



                $shipping_label = $dom->createElement('g:shipping_label', 0.00);

                $product->appendChild($shipping_label);

                $gender = $dom->createElement('g:gender', '<![CDATA[ Female ]]>');

                $product->appendChild($gender);

                $age_group = $dom->createElement('g:age_group', '<![CDATA[ Adult ]]>');

                $product->appendChild($age_group);

                $metal = $dom->createElement('g:metal', $metalType);

                $product->appendChild($metal);

                $identifier_exists = $dom->createElement('g:identifier_exists', $productIdentifierExists);

                $product->appendChild($identifier_exists);

                $channelNew->appendChild($product);
                $root->appendChild($channelNew);

            }





        }
            // echo "aff<pre>";
            // print_r($productsArray[$i]['id']);
            // die;



        // }

        $dom->appendChild($root);

        $dom->save($filePath);

    }


    // public function newTestXML($dataArray)
    // {
    //     $filePath = public_path('files/book123.xml');
    //     $xmlObject   = new \DOMDocument();
    //     $xml = $xmlObject->createElement('root');
    //     $xml_a = $xmlObject->createElement('parent');
    //     $xml_b = $xmlObject->createElement('child');
    //     $xml_b->setAttribute('attribute','value');
    //     $xml_b->appendChild(new \DOMElement('item', 'itemValue'));
    //     $xml_a->appendChild($xml_b);
    //     $xml->appendChild($xml_a);
    //     $xmlObject->appendChild($xml);
    //     echo $xmlObject->save($filePath);
    // }
}
