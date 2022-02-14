$('.piezaImagen-collection').collection({
    allow_duplicate: false,
    allow_up: false,
    allow_down: false,
    add: '<h6><a href="#" class="badge badge-danger" title="Agregar Item"><span class="fas fa-plus"></span> Agregar Item</a></h6>',
    add_at_the_end: true,
    // here is the magic!
    elements_selector: 'tr.item',
    elements_parent_selector: '%id% tbody',
    before_add: function (collection, element) {
        
    },
    after_add: function(collection, element) { 
        
    },
    after_remove: function (collection, element) {
        //recalcular();
    },
    after_init: function(collection) {
            
    }
});

