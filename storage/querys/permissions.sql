INSERT INTO permissions(name, slug) values 
('Ver usuarios', 'users.index'), ('Crear usuarios', 'users.store'), ('Actualizar usuarios', 'users.update'), ('Ver detalle de usuario', 'users.show'), ('Eliminar usuarios', 'users.destroy'),

('Ver negocios', 'stores.index'), ('Crear negocios', 'stores.store'), ('Actualizar negocios', 'stores.update'), ('Ver detalle de negocio', 'stores.show'), ('Eliminar negocios', 'stores.destroy'),

('Ver categorias', 'categories.index'), ('Crear categorias', 'categories.store'), ('Actualizar categorias', 'categories.update'), ('Ver categoria', 'categories.show'), ('Eliminar categorias', 'categories.destroy'),

('Ver categorias de productos', 'product.categories.index'), ('Crear categorias de productos', 'product.categories.store'), ('Actualizar categorias de productos', 'product.categories.update'), ('Ver detalle de categoria de productos', 'product.categories.show'), ('Eliminar categorias de productos', 'product.categories.destroy'),

('Ver sub-categorias de productos', 'sub.categories.index'), ('Crear sub-categorias de productos', 'sub.categories.store'), ('Actualizar sub-categorias de productos', 'sub.categories.update'), ('Ver sub-categoria de productos', 'sub.categories.show'), ('Eliminar sub-categorias de productos', 'sub.categories.destroy'), ('Listar sub-categoria con productos', 'sub.categories.list'),

('Ver productos', 'products.index'), ('Crear productos', 'products.store'), ('Actualizar productos', 'products.update'), ('Ver detalle de producto', 'products.show'), ('Eliminar productos', 'products.destroy'), ('Listar productos', 'products.list'),

('Ver clientes', 'clients.index'), ('Crear clientes', 'clients.store'), ('Actualizar clientes', 'clients.update'), ('Ver detalle de cliente', 'clients.show'), ('Eliminar clientes', 'clients.destroy'), ('Actualizar estado de clientes', 'clients.status'),

('Ver delivery', 'delivery.index'), ('Crear delivery', 'delivery.store'), ('Actualizar delivery', 'delivery.update'), ('Ver detalle de delivery', 'delivery.show'), ('Eliminar delivery', 'delivery.destroy'),

('Ver cupones', 'coupons.index'), ('Crear cupones', 'coupons.store'), ('Actualizar cupones', 'coupons.update'), ('Ver detalle de cupon', 'coupons.show'), ('Eliminar cupones', 'coupons.destroy'), ('Actualizar estado de cupones', 'coupons.status'),

('Ver ordenes', 'orders.index'), ('Crear ordenes', 'orders.store'), ('Actualizar ordenes', 'orders.update'), ('Ver detalle de orden', 'orders.show'), ('Eliminar ordenes', 'orders.destroy');
