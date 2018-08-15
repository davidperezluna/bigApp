<?php 
namespace AppBundle\services;
/**
* 
*/
class Helpers 
{
	
	public function json($data){
		$normalizer = new \Symfony\Component\Serializer\Normalizer\ObjectNormalizer();
		$normalizer->setCircularReferenceHandler(function ($object) {
		    return $object->getId();
		});
		$encoders =  new \Symfony\Component\Serializer\Encoder\JsonEncoder();
		
		$serializer = new \Symfony\Component\Serializer\Serializer(array($normalizer), array($encoders));
		$json = $serializer->serialize($data, 'json');
		
		$response = new \Symfony\Component\HttpFoundation\Response();
		$response->setContent($json);
		$response->headers->set("Content-Type", "application/json");
		
		return $response;
	}
}