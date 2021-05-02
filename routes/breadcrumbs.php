<?php

/** Resumen **/
Breadcrumbs::for('/', function ($trail) {
    $trail->push('Resumen', route('home'), ['icon' => 'donut_large']);
});

Breadcrumbs::for('home-end', function ($trail) {
    $trail->parent('/');
    $trail->push('Estadisticas generales', '', ['icon' => 'timeline']);
});


/** Usuarios **/
Breadcrumbs::for('users', function ($trail) {
    $trail->push('Usuarios', route('users.index'), ['icon' => 'face']);
});

Breadcrumbs::for('users-end', function ($trail) {
    $trail->parent('users');
    $trail->push('Todos los usuarios', '', ['icon' => 'groups']);
});


/** Roles **/
Breadcrumbs::for('roles', function ($trail) {
    $trail->push('Roles', route('roles.index'), ['icon' => 'room_preferences']);
});

Breadcrumbs::for('roles-end', function ($trail) {
    $trail->parent('roles');
    $trail->push('Todos los roles', '', ['icon' => 'list']);
});


/** Pedidos **/
Breadcrumbs::for('orders', function ($trail) {
    $trail->push('Pedidos', route('orders.index'), ['icon' => 'add_shopping_cart']);
});

Breadcrumbs::for('orders-end', function ($trail) {
    $trail->parent('orders');
    $trail->push('Nuevo pedido', '', ['icon' => 'local_mall']);
});


/** Clientes **/
Breadcrumbs::for('clients', function ($trail) {
    $trail->push('Clientes', route('clients.index'), ['icon' => 'local_mall']);
});

Breadcrumbs::for('clients-end', function ($trail) {
    $trail->parent('clients');
    $trail->push('Todos los clientes', '', ['icon' => 'groups']);
});


/** Negocios **/
Breadcrumbs::for('stores', function ($trail) {
    $trail->push('Negocios', route('stores.index'), ['icon' => 'store']);
});

Breadcrumbs::for('stores-end', function ($trail) {
    $trail->parent('stores');
    $trail->push('Todos los negocios', '', ['icon' => 'local_mall']);
});


/** Repartidores **/
Breadcrumbs::for('delivery', function ($trail) {
    $trail->push('Repartidores', route('delivery.index'), ['icon' => 'delivery_dining']);
});

Breadcrumbs::for('delivery-end', function ($trail) {
    $trail->parent('delivery');
    $trail->push('Todos los repartidores', '', ['icon' => 'groups']);
});


/** Cupones **/
Breadcrumbs::for('coupons', function ($trail) {
    $trail->push('Cupones', route('stores.index'), ['icon' => 'sell']);
});

Breadcrumbs::for('coupons-end', function ($trail) {
    $trail->parent('coupons');
    $trail->push('Todos los cupones', '', ['icon' => 'local_mall']);
});


/** Registros **/
Breadcrumbs::for('reports', function ($trail) {
    $trail->push('Registros', route('reports.index'), ['icon' => 'format_list_bulleted']);
});

Breadcrumbs::for('reports-end', function ($trail) {
    $trail->parent('reports');
    $trail->push('Todos los registros', '', ['icon' => 'description']);
});


/** Soporte **/
Breadcrumbs::for('support', function ($trail) {
    $trail->push('Soporte', route('support.index'), ['icon' => 'feedback']);
});

Breadcrumbs::for('support-end', function ($trail) {
    $trail->parent('support');
    $trail->push('Tickets de ayuda', '', ['icon' => 'device_unknown']);
});


/** Perfil **/
Breadcrumbs::for('profile', function ($trail) {
    $trail->push('Perfil de Usuario', route('users.profile'), ['icon' => 'settings']);
});

Breadcrumbs::for('profile-end', function ($trail) {
    $trail->parent('profile');
    $trail->push('Detalles', '', ['icon' => 'face_retouching_natural']);
});


/** Ubicaciones **/
Breadcrumbs::for('locations', function ($trail) {
    $trail->push('Ubicaciones', route('locations.index'), ['icon' => 'map']);
});

Breadcrumbs::for('locations-end', function ($trail) {
    $trail->parent('locations');
    $trail->push('Detalles', '', ['icon' => 'list']);
});


/** Categorias de negocios **/
Breadcrumbs::for('categories', function ($trail) {
    $trail->push('Categorias', route('categories.index'), ['icon' => 'class']);
});

Breadcrumbs::for('categories-end', function ($trail) {
    $trail->parent('categories');
    $trail->push('Detalles', '', ['icon' => 'list']);
});
