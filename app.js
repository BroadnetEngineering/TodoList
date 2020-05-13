
	(function(){
		var addButton = document.getElementById("addButton");
		var taskField = document.getElementById('task');
		var initialText = '';

		const $ul = document.querySelector('ul');
		$ul.addEventListener('click', function(e) {
			e.preventDefault();
			var currentElement = e.target.classList;
			if (currentElement.contains('delete')) {
				onDeleteTask(e);
			}else if (currentElement.contains('edit')) {
				onEditTask(e);
			}else if(currentElement.contains('discardChanges')){
				discardChanges(e);
			}else if(currentElement.contains('saveChanges')){
				saveChanges(e);
			}
		});

		function onDeleteTask(e){
			const li = e.target.parentElement.parentElement;
			const todoId = li.getAttribute('id').replace('todo-','');
			var xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp=new XMLHttpRequest();
			} else {
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			xmlhttp.onreadystatechange=function() {
				if (this.readyState === 4 && this.status === 200) {
					var currentTodoItem = document.getElementById(this.responseText);
					currentTodoItem.parentNode.removeChild(currentTodoItem);
				}
			}
			
			xmlhttp.open("GET",`ajax.php?action=deleteTask&id=${todoId}`, true);
			xmlhttp.send();
		}

		// handles onEditTask
		function onEditTask(e){
			const currentTODO = e.target.parentElement.parentElement;
			var controlButtons = '<div class="editTodoItem">'+
									'<a class="saveChanges" href="#">Save</a> or <a class="discardChanges" href="#">Cancel</a>'+
								'</div>';
			initialText = currentTODO.querySelector('.text').textContent;
			currentTODO.querySelector('.text').innerHTML = '<input type = "text" value="'+initialText+'"/>' + controlButtons;
		}

		// Handles discardChanges
		function discardChanges(e){
			const currentTODO = e.target.parentElement.parentElement.parentElement;
			currentTODO.querySelector('.text').innerHTML = initialText;
		}

		// Handles updateTask
		function saveChanges(e){
			const currentTODO = e.target.parentElement.parentElement.parentElement;
			var text = currentTODO.querySelector('.text > input').value;
			if(text.length !== 0){
				var xmlhttp;
				if (window.XMLHttpRequest) {
					xmlhttp=new XMLHttpRequest();
				} else {
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				xmlhttp.onreadystatechange=function() {
					if (this.readyState === 4 && this.status === 200) {
						var response = this.responseText;
						currentTODO.querySelector('.text').innerHTML = response;
					}
				}
				xmlhttp.open("GET",`ajax.php?action=updateTask&id=${currentTODO.id.split('-')[1]}&text=${text}`, true);
				xmlhttp.send();
			}else{
				alert('Field cannot be empty');
			}
		}

		// Handles addTask
		addButton.addEventListener('click', function(e){
			e.preventDefault();
			var xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp=new XMLHttpRequest();
			} else {
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			xmlhttp.onreadystatechange=function() {
				if (this.readyState === 4 && this.status === 200) {
					var msg =this.responseText;
					var parser  = new DOMParser();
					var wrapper = parser.parseFromString(msg, "text/html");
					var node    = wrapper.getElementsByTagName('li')[0];
					document.getElementsByClassName("todoList")[0].appendChild(node);
					taskField.value = '';
				}
			}
			var taskText = document.getElementById('task').value;
			xmlhttp.open("GET",`ajax.php?action=addTask&text=${taskText}`, true);
			xmlhttp.send();
		});
	}());