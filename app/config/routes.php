<?php
/*
 * route
 * add route to set some action
 * inject route service
 */
$routes = Service::inject('route');
/*
 * add the route custom
 */
$routes->directory('data');
