var ControlBaseDataView = elementor.modules.controls.BaseData;

var ControlMediaItemView = elementor.modules.controls.BaseData.extend(
    {

	ui: function() {
		var ui = ControlBaseDataView.prototype.ui.apply( this, arguments );

		ui.addImages = '.eep-control-gallery-add';
		ui.clearGallery = '.eep-control-gallery-clear';
		ui.galleryThumbnails = '.eep-control-gallery-all-thumbnails';
		ui.status = '.eep-control-gallery-status-title';

		return ui;
	},

	events: function() {
		return _.extend( ControlBaseDataView.prototype.events.apply( this, arguments ), {
			'click @ui.addImages': 'onAddImagesClick',
			'click @ui.clearGallery': 'onClearGalleryClick',
			'click @ui.galleryThumbnails': 'onGalleryThumbnailsClick',
		} );
	},

	onReady: function() {
		this.initRemoveDialog();
	},
	applySavedValue: function() {
	    var images      = this.getControlValue();
	    var imagesCount = images.length;
	    var hasImages   = imagesCount > 0 ? true: false; 

	    this.$el
		.toggleClass( 'eep-gallery-has-images', hasImages )
		.toggleClass( 'eep-gallery-empty', ! hasImages );

	    var $galleryThumbnails = this.ui.galleryThumbnails;

	    $galleryThumbnails.empty();

	    this.ui.status.text( elementor.translate( hasImages ? 'gallery_images_selected' : 'gallery_no_images_selected', [ imagesCount ] ) );

	    if ( ! hasImages ) {
		return;
	    }

	    images.forEach( function( image ) {
		var $thumbnail = jQuery( '<div>', { class: 'eep-control-gallery-thumbnail' } );
		$thumbnail.css( 'background-image', 'url(' + image.url + ')' );
		$galleryThumbnails.append( $thumbnail );
	    } );
	},

	hasImages: function() {
	    return !! this.getControlValue().length;
	},

	openFrame: function( action ) {
	    this.initFrame( action );
	    this.frame.open();
	},

	initFrame: function( action ) {

	    var frameStates = {
		create: 'gallery',
		add: 'gallery-library',
		edit: 'gallery-edit',
	    };
	    // Create state
	    
	    var options = {
		frame: 'post',
		multiple: true,
		state: frameStates[ action ],
		button: {
		    text: elementor.translate( 'insert_media' ),
		},
	    };
	    if ( this.hasImages() ) {
		options.selection = this.fetchSelection();
	    }
	    this.frame = new wp.media (options);
	    this.frame.on( {
		update: this.select, // media
		'menu:render:default': this.menuRender,
		'content:render:browse': this.gallerySettings,
	    }, this);
	},
	select: function( selection ) {
	    var state = this.frame.state();
	    var video_url = '';
	    var images = [];

	    selection.each( function( image ) {
		var id  = image.get('id');
		var url = image.get( 'url' );
		var text_id  = 'attachments-'+id+'-text_field';
		var check_id = 'attachments-'+id+'-checkbox_field';
		var push_obj = {id : id, url: url};

		var compat  = image.get('compat');
		var $compat = jQuery(jQuery.parseHTML(compat.item));

		if($compat.find( "#" + check_id ).is(':checked')){
		    var text_val = $compat.find( "#" + text_id ).val();
		    if(text_val){
			let result = text_val.match(/^https?:[/].+?youtu.+?\W([\w|-]+)$/);
			if(result[1]){
			    var video_id = result[1]; // (first capturing group)
			    push_obj.url = 'https://img.youtube.com/vi/'+video_id+'/sddefault.jpg';
			    push_obj.youtube_id =  video_id;
			    push_obj.youtube_url = text_val;
			}
		    }
		}
		images.push( push_obj );
	    });

	    this.setValue( images );

	    this.applySavedValue();
	},

	menuRender: function( view ) {
	    view.unset( 'insert' );
	    view.unset( 'featured-image' );
	},

	gallerySettings: function( browser ) {
	    browser.sidebar.on( 'ready', function() {
		browser.sidebar.unset( 'gallery' );
	    } );
	},

	fetchSelection: function() {
	    var attachments = wp.media.query( {
		orderby: 'post__in',
		order: 'ASC',
		type: 'image',
		meta: true,
		perPage: -1,
		post__in: _.pluck( this.getControlValue(), 'id' ),
	    } );

	    var selection =  new wp.media.model.Selection( attachments.models, {
		props: attachments.props.toJSON(),
		multiple: true,
		meta: true,
	    } );
	    return selection;
	},

	onBeforeDestroy: function() {
		if ( this.frame ) {
			this.frame.off();
		}

		this.$el.remove();
	},

	resetGallery: function() {
		this.setValue( [] );
		this.applySavedValue();
	},

	initRemoveDialog: function() {
		var removeDialog;

		this.getRemoveDialog = function() {
			if ( ! removeDialog ) {
				removeDialog = elementorCommon.dialogsManager.createWidget( 'confirm', {
					message: elementor.translate( 'dialog_confirm_gallery_delete' ),
					headerMessage: elementor.translate( 'delete_gallery' ),
					strings: {
						confirm: elementor.translate( 'delete' ),
						cancel: elementor.translate( 'cancel' ),
					},
					defaultOption: 'confirm',
					onConfirm: this.resetGallery.bind( this ),
				} );
			}

			return removeDialog;
		};
	},

	onAddImagesClick: function() {
		this.openFrame( this.hasImages() ? 'add' : 'create' );
	},

	onClearGalleryClick: function() {
		this.getRemoveDialog().show();
	},

	onGalleryThumbnailsClick: function() {
	    this.openFrame( 'edit' );
	},
} );

elementor.addControlView('media-gallery', ControlMediaItemView);
