<?php
class custom_product_plugin
{
    public function __construct()
    {
        // Register custom post type and taxonomies
        add_action('init', array( $this, 'register_custom_product_post_type' ));
        add_action('init', array( $this, 'register_custom_taxonomies' ));
        // Add meta boxes
        add_action('add_meta_boxes', array( $this, 'custom_product_meta_boxes' ));
        // Save custom field data
        add_action('save_post', array( $this, 'save_custom_product_meta' ));
    }
    public function register_custom_product_post_type()
{
    $labels = array(
        'name' => __('Products', 'product'), // Replace 'product' with your theme or plugin's text domain.
        'singular_name' => __('Product', 'Product'),
        'all_items' => __('All Products', 'Product'), 
        'add_new' => __('Add New Product', 'Product'),
        'add_new_item' => __('Add New Product', 'Product'),
        'edit_item' => __('Edit Product', 'Product'),
        'new_item' => __('New Product', 'Product'),
        'view_item' => __('View Product', 'Product'),
        'view_items' => __('View Products', 'Product'),
        'search_items' => __('Search Products', 'Product'),
        'not_found' => __('No Products found', 'Product'),
        'not_found_in_trash' => __('No Products found in Trash', 'Product'),
        "archives" => __("Product", "Product")
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-cart', // You can choose a custom icon.
        'menu_position' => 2,
        'supports' => array('title', 'editor', 'thumbnail'),
        "has_archive" => true
    );

    register_post_type('products', $args);
}

public function register_custom_taxonomies()
{
    // Product Category
    register_taxonomy(
        'product_category',
        'products', // Use 'products' as the post type
        array(
            'label' => __('Product Categories', 'product'), // Replace 'product' with your theme or plugin's text domain.
            'hierarchical' => true,
        )
    );

    // Brand
    register_taxonomy(
        'brand',
        'products', // Use 'products' as the post type
        array(
            'label' => __('Brands', 'product'), // Replace 'product' with your theme or plugin's text domain.
            'hierarchical' => false,
        )
    );
}

    public function custom_product_meta_boxes()
    {
    add_meta_box(
        'product_price_and_purchase_price_meta_box',
        'Product Prices',
        array($this, 'render_product_prices_meta_box'),
        'products',
        'side',
        'default'
    );

     
    }
   
   

   
    public function render_product_prices_meta_box($post)
{
    // Get the existing product price and purchase price values
    $product_price = get_post_meta($post->ID, '_product_price', true);
    $product_purchase_price = get_post_meta($post->ID, '_product_purchase_price', true);
    ?>
    <label for="product_price">Product Price:</label>
    <input type="text" id="product_price" name="product_price" value="<?php echo esc_attr($product_price); ?>" placeholder="Enter price (e.g., 10.99)" /><br>

    <label for="product_purchase_price">Product Purchase Price:</label>
    <input type="text" id="product_purchase_price" name="product_purchase_price" value="<?php echo esc_attr($product_purchase_price); ?>" placeholder="Enter purchase price (e.g., 8.99)" />

    <!-- Add other fields here if needed, e.g., product_name, product_featured_image_id, product_description -->
    <?php
}

public function save_custom_product_meta($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = ['product_price', 'product_purchase_price'];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}

}
new custom_product_plugin();
