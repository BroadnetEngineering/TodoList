$( document ).ready(function() {
	var $submitButton,
		$newItemInput,
		$editButtons,
		$deleteButtons;

	assignDomItems();
    initEventListeners();

    function assignDomItems() {
    	assignInputItems();
    	assignListItems();
    }

    function initEventListeners() {
    	initSubmitEvent();
    	initDeleteEvent();
    	initEditEvent();
    	initCheckEvent();
    }

    function initSubmitEvent() {
    	$submitButton.click(function(e){
    		e.preventDefault();

    		var newItemValue = $newItemInput[0].value;
    		var $toDoList = $('.todo-list');

    		$.when(appendToList()).then(reassignVariables());

    		function appendToList() {
		    	$toDoList.append( 
		    		'<li class="list-item">' + 
	          			'<input class="item-check" type="checkbox" />' +
	      				'<span class="list-item-content">'+ newItemValue + '</span>' +
	      				'<div class="icon-container">' +
	        				'<i class="material-icons edit-icon">create</i>' +
	        				'<i class="material-icons delete-icon">delete</i>' +
						'</div>' +
	        		'</li>' 
	        	);

	        	$newItemInput[0].value = null;
    		}

    		function reassignVariables() {
    			assignListItems();
		    	initCheckEvent();
		    	initEditEvent();
		    	initDeleteEvent();
    		}

    	});
    }

    function initEditEvent() {

    	$editButtons.click(function(e){
    		e.preventDefault();
    		var currentItemContent = $(e.target).parent().parent().find('.list-item-content');
    		var itemContent = currentItemContent.html();

    		currentItemContent.html('<input class="edit-input" type="text" value="' + itemContent + '" />');

    		$('.edit-input').focus();

    		$('.edit-input').keypress(function (e) {

				if (e.which == 13) {
	    			itemContent = $('.edit-input').val();

	    			currentItemContent.html(itemContent);

					return false;
				}
    		});

    		console.log(itemContent);
    	});

    }

    function initDeleteEvent() {

    	$deleteButtons.click(function(e){
    		e.preventDefault();
    		$(e.target).parent().parent().remove();
    	});

    }

    function initCheckEvent() {

    	$checkBoxes.click(function(e){
    		console.log($(e.target).parent());

    		$(e.target).parent().toggleClass('complete');

    		if($(e.target).checked) {

    		}
    	});

    }

    function assignInputItems() {
    	$submitButton = $('#newItemSubmit');
    	$newItemInput = $('#newItemInput');
    }

    function assignListItems() {
    	$editButtons = $('.edit-icon');
    	$deleteButtons = $('.delete-icon');
    	$checkBoxes = $('.item-check');
    }
});