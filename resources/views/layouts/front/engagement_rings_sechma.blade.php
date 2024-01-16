<?php

if(isset($categoryData->faq_category) && !empty($categoryData->faq_category)){
  $getFAQDataSolutions = getFaqByCategory(explode(',', isset($categoryData->faq_category)?$categoryData->faq_category:''));
}else{
  $getFAQDataSolutions = getFaqByCategorySlug(request()->path());
}

if(isset($getFAQDataSolutions) && count($getFAQDataSolutions)){
  $getSchemaArray = [];
  foreach ($getFAQDataSolutions as $datavalue) {
    $dataArray['@type'] = 'Question';
    $dataArray['name'] = $datavalue->title;
    $dataArray['acceptedAnswer'] = [
      '@type' => 'Answer',
      'text' => $datavalue->description,
    ];
    array_push($getSchemaArray, $dataArray);
  }

  $faqSchemaDynamicFormat = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' =>
    $getSchemaArray,
  ];

  $faqSchemaDynamicFormat = json_encode($faqSchemaDynamicFormat);

  echo '<script type="application/ld+json">' . $faqSchemaDynamicFormat . '</script>';
}
?>
