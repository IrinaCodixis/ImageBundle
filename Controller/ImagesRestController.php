<?php

namespace Mipa\ImageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Mipa\ImageBundle\Entity\Images;
use Mipa\ImageBundle\Form\ImagesType;

/**
 * @NamePrefix("api_")
 *
 */
 class ImagesRestController extends Controller
{
    /**
     * Get the list of images
     *
     * @return array data
     *
     * @ApiDoc()
     */
    public function getImagesAction()
    {
        $imagine = $this->get('liip_imagine.cache.manager');
        $em = $this->getDoctrine()->getManager();
        
        $images = $em->getRepository('MipaImageBundle:Images')->findAll();
		
		foreach ($images as $k => $image) {
            $image->setImage($imagine->getBrowserPath(
                $image->getImage(),
                'my_thumb'
            ));
        }
        $view = new View($images);
        return $this->get('fos_rest.view_handler')->handle($view);
    }
}

?>