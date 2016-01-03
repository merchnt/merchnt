<?php
namespace FastRouteAnnotations\Annotations;

abstract class HttpMethod implements Annotation
{
    /**
     * @var string
     */
    public $uri;
}