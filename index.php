<?php
require('./src/app.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.3.5/tailwind.css" rel="stylesheet">
        <script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
        <script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js" defer></script>
    </head>
    <body class="bg-gray-800" x-data="initialData()">
        <div class="container mx-auto flex flex-col">
            <div class="mx-auto h-auto md:mt-32 mt-20 md:w-1/2 w-10/12 p-5 bg-gray-200">
            <div class="flex">
                <h3 class="text-4xl mx-auto">Todo List</h3>
            </div>
            <div class="flex">
                <form class="flex flex-col w-full">
                    <input class="w-full border border-gray-200 text-center rounded-md" placeholder="Type here then press enter to add a new task" maxlength="25" type="text" x-model="addForm.text" x-on:keydown.enter.prevent="add()" />
                </form>
            </div>
            <ul>
                <template x-for="(task, index) in tasks" :key="index">
                    <li class="w-full text-lg text-gray-700 flex flex-row my-1">
                        <span class="mr-auto overflow-hidden" x-text="task.text"></span>
                        <input class="my-auto" x-model="task.completed" type="checkbox" @click="$nextTick(()=>{complete(task)})" />
                        <button class="pl-2 my-auto" @click.prevent="editTask(task)">&#9997;</button>
                        <button class="pl-2 my-auto" @click.prevent="remove(task)">&#9940;</button>
                    </li>
                </template>
            </ul>            
            <button class="mt-5 w-full self-end bg-red-400 p-2 px-4 rounded-md" @click.prevent="destroy()">Clear Data</button>
            </div>
            
        </div>
        <div x-show="showEditForm" class="fixed w-full h-full top-0 left-0 flex items-center justify-center">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>        
            <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <div class="py-4 text-left px-6" >
                    <form class="flex flex-col justify-between items-center pb-3" @click.away="toggleEditForm()" >
                        <h3 class="text-2xl uppercase">Edit Task</h3>
                        <div class="flex my-2 w-full">
                            <label class="uppercase text-md ml-10 w-1/5 mr-2">Task Text</label>
                            <input type="text" class="border border-gray-300 flex w-7/12 leading-none" x-model="editForm.text" />
                        </div>
                        <div class="flex my-2 w-full">
                            <label class="uppercase text-md ml-10 w-1/4 mr-2">Completed</label>
                            <input class="my-auto h-4 w-4"type="checkbox" x-model="editForm.completed" x-bind:checked="editForm.completed" />
                        </div>
                        <button class="w-10/12 bg-gray-400 p-1 px-2 rounded-md uppercase" @click.prevent="update()">Update Task</button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            var data = JSON.parse('<?php echo(json_encode($todoList)); ?>');
            
            function initialData(){
                return {
                    tasks: data,
                    showEditForm: false,
                    showAddForm: false,
                    addForm: {
                        status: '',
                        errorMessages: [],
                        text: ''
                    },
                    editForm: {
                        status: '',
                        errorMessages: [],
                        id: 0,
                        text: '',
                        completed: false
                    },
                    editTask(task){
                        this.showEditForm = true;
                        this.editForm = Object.assign(this.editForm,task);
                    },
                    complete(task){
                        var data = JSON.stringify({
                            id: task.id,
                            completed: task.completed
                        });

                        fetch("/index.php?action=complete", {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: data
                        }).then(resp=>{
                            if(resp.status == 422){
                                throw Error(resp) 
                            }else{
                                return resp.json()
                            }
                        })
                        .then((data)=>{
                            this.tasks = data
                        }).catch(resp=>{
                            console.log(resp);
                        });
                    },
                    destroy(){
                        fetch("/index.php?action=destroy", {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: data
                        }).then(resp=>{
                            if(resp.status == 422){
                                throw Error(resp) 
                            }
                            return resp.json()
                        }).then((data)=>{
                            this.tasks = data;
                        });
                    },
                    update(){
                        if(this.editForm.text == ""){
                            this.editForm.status = "error";
                            this.editForm.errorMessages.push("The task cannot be empty.");
                            return;
                        }else{
                            this.editForm.status = "good";
                            this.editForm.errorMessages = [];
                        }

                        var data = JSON.stringify({
                            id:this.editForm.id,
                            text:this.editForm.text,
                            completed: this.editForm.completed
                        });

                        fetch("/index.php?action=update", {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: data
                        }).then(resp=>{
                            if(resp.status == 422){
                                throw Error(resp) 
                            }
                            return resp.json()})
                        .then((data)=>{
                            this.editForm.errorMessages = [];
                            this.editForm.status = "";
                            this.tasks = data;
                            this.showEditForm = false;
                        }).catch(resp=>{
                            this.editForm.status = "error";
                            this.editForm.errorMessages.push(resp.error);
                        });
                    },
                    add(){
                        if(this.addForm.text == ""){
                            this.addForm.status = "error";
                            this.addForm.errorMessages.push("The task cannot be empty.");
                            return;
                        }else{
                            this.addForm.status = "good";
                            this.addForm.errorMessages = [];
                        }

                        var data = JSON.stringify({
                            taskText: this.addForm.text
                        });

                        fetch("/index.php?action=add", {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: data
                        }).then(resp=>{
                            if(resp.status == 422){
                                throw Error(resp) 
                            }
                            return resp.json()})
                        .then((data)=>{
                            this.addForm.text = "";
                            this.addForm.errorMessages = [];
                            this.addForm.status = "";
                            this.tasks = data
                        }).catch(resp=>{
                            this.addForm.status = "error";
                            this.addForm.errorMessages.push(resp.error);
                        });
                    },
                    remove(task){
                        var data = JSON.stringify({
                            id: task.id
                        });

                        fetch("/index.php?action=remove", {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: data
                        }).then(resp=>{
                            if(resp.status == 422){
                                throw Error(resp) 
                            }
                            return resp.json()
                        }).then((data)=>{
                            console.log(data);
                            this.tasks = data;
                        });
                    },
                    toggleAddForm(){
                        this.showAddForm = !this.showAddForm;
                    },
                    toggleEditForm(){
                        console.log("Test");
                        this.showEditForm = !this.showEditForm;
                    }
                };
            }

        </script>
    </body>
</html>