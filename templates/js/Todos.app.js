var app = app || {};
var ENTER_KEY = 13;
var ESC_KEY = 27;

$(function () {
  'use strict';

  /*

  Backbone.js uses MVC

   */

  // To-do Model
  // ----------

  // Our basic **To-do** model has `title`, `order`, and `completed` attributes.
  app.Todo = Backbone.Model.extend({
    // Default attributes for a to-do
    defaults: {
      title: '',
      completed: false
    },

    parse : function (response) {
      if (response && typeof response === 'object') {
        response.completed = !!+response.completed;
        response.order = parseInt(response.order);
      }
      return response;
    },

    // Toggle the `completed` state of this to-do item.
    toggle: function () {
      this.save({
        completed: !this.get('completed')
      }, {
          ajaxSync: true
        });
    },
    url: "items"
  });

  // Todos Collection
  // ---------------

  // The collection of todos is backed by *localStorage* & a remote server.
  var Todos = Backbone.Collection.extend({
    // Reference to this collection's model.
    model: app.Todo,

    parse : function (response) {
      if (response && typeof response === 'object') {
        response.completed = !!+response.completed;
        response.order = parseInt(response.order);
      }
      return response;
    },

    // Save all of the to-do items under this example's namespace.
    localStorage: new Backbone.LocalStorage('todos-backbone'),

    // Filter down the list of all to-do items that are finished.
    completed: function () {
      return this.where({completed: true});
    },

    // Filter down the list to only to-do items that are still not finished.
    remaining: function () {
      return this.where({completed: false});
    },

    nextOrder: function () {
      return this.length ? this.last().get('order') + 1 : 1;
    },

    // Todos are sorted by their original insertion order.
    comparator: 'order',
    refreshFromServer : function(options) {
      return Backbone.ajaxSync('read', this, options);
    },
    url : "items"
  });

  // Create our global collection of **To-dos**.
  app.todos = new Todos();

  // To-do Item View
  // --------------

  // The to-do item is matched...
  app.TodoView = Backbone.View.extend({

    //...to the DOM element for a list tag.
    tagName:  'li',

    // Define the template function for a single item.
    template: _.template($('#item-template').html()),

    // The DOM events specific to an item.
    events: {
      'click .toggle': 'toggleCompleted',
      'dblclick label': 'edit',
      'click .destroy': 'clear',
      'keypress .edit': 'updateOnEnter',
      'keydown .edit': 'revertOnEscape',
      'blur .edit': 'close'
    },

    // The TodoView is the controller, registering events for the model.
    initialize: function () {
      this.listenTo(this.model, 'change', this.render);
      this.listenTo(this.model, 'destroy', this.remove);
      this.listenTo(this.model, 'visible', this.toggleVisible);
    },

    // Re-render the titles of the items.
    render: function () {
      if (this.model.changed.id !== undefined) {
        //return;
      }
      this.$el.html(this.template(this.model.toJSON()));
      this.$el.toggleClass('completed', this.model.get('completed'));
      this.toggleVisible();
      this.$input = this.$('.edit');
      this.$('.toggle').show();
      return this;
    },

    toggleVisible: function () {
      this.$el.toggleClass('hidden', this.isHidden());
    },

    isHidden: function () {
      return this.model.get('completed') ?
        app.TodoFilter === 'active' :
        app.TodoFilter === 'completed';
    },

    // Toggle the `"completed"` state of the model.
    toggleCompleted: function () {
      this.model.toggle();
    },

    // Switch this view into `"editing"` mode, displaying the input field.
    edit: function () {
      this.$el.addClass('editing');
      this.$input.focus();
    },

    // Close the `"editing"` mode, saving changes to the item.
    close: function () {
      var value = this.$input.val();
      var trimmedValue = value.trim();

      if (!this.$el.hasClass('editing')) {
        return;
      }

      if (trimmedValue) {
        this.model.save({
          title: trimmedValue
        }, {
          ajaxSync: true
        });
      } else {
        this.clear();
      }

      this.$el.removeClass('editing');
    },

    // If you hit `enter`, we've finished editing the item.
    updateOnEnter: function (e) {
      if (e.which === ENTER_KEY) {
        this.close();
      }
    },

    // By pressing `escape` you revert your change by leaving
    // the `editing` state.
    revertOnEscape: function (e) {
      if (e.which === ESC_KEY) {
        this.$el.removeClass('editing');
        // Also reset the hidden input back to the original value.
        this.$input.val(this.model.get('title'));
      }
    },

    // Remove the item, destroy the model and delete its view.
    clear: function () {
      // Without a title, the to-do will be deleted from the server
      this.model.set({title: ''}).save({ajaxSync: true});
      this.model.destroy();
    }
  });

  // To-do App View
  // --------------

  // Our overall **AppView** is the main controller for the UI.
  app.AppView = Backbone.View.extend({

    // Bind the App to the existing skeleton
    // already present in the HTML.
    el: '#todoapp',

    // The template for the line of statistics at the bottom of the app.
    statsTemplate: _.template($('#stats-template').html()),

    // Delegated events for creating new items and clearing completed ones.
    events: {
      'keypress #new-todo': 'createOnEnter',
      'click #clear-completed': 'clearCompleted',
      'click #toggle-all': 'toggleAllComplete'
    },

    // At initialization we bind to the relevant events on the 
    // collection as well as when items are added or changed. 
    initialize: function () {
      this.allCheckbox = this.$('#toggle-all')[0];
      this.$input = this.$('#new-todo');
      this.$footer = this.$('footer');
      this.$main = this.$('#main');
      this.$list = $('#todo-list');

      this.listenTo(app.todos, 'add', this.addOne);
      this.listenTo(app.todos, 'reset', this.addAll);
      this.listenTo(app.todos, 'change:completed', this.filterOne);
      this.listenTo(app.todos, 'filter', this.filterAll);
      this.listenTo(app.todos, 'all', _.debounce(this.render, 0));

      // Supresses 'add' events with {reset: true} and prevents the app view
      // from being re-rendered for every model. 
      app.todos.fetch({reset: true});
      
      // In order to update the collection, we have to save every model
      var collection = app.todos;
      collection.refreshFromServer({success: function(freshData) {
          collection.reset(freshData);
          collection.each(function(model) {
            model = collection.parse(model);
            model.save();
          });
        }});
    },

    // Re-rendering the App means refreshing statistics
    render: function () {
      var completed = app.todos.completed().length;
      var remaining = app.todos.remaining().length;

      if (app.todos.length) {
        this.$main.show();
        this.$footer.show();

        this.$footer.html(this.statsTemplate({
          completed: completed,
          remaining: remaining
        }));

        this.$('.filters li a')
          .removeClass('selected')
          .filter('[href="#/' + (app.TodoFilter || '') + '"]')
          .addClass('selected');
      } else {
        this.$main.hide();
        this.$footer.hide();
      }

      this.allCheckbox.checked = !remaining;
    },

    // Add a single to-do item to the list by creating a view,
    // and appending its element to the `<ul>`.
    addOne: function (todo) {
      // console.log(todo);
      var view = new app.TodoView({ model: todo });
      this.$list.append(view.render().el);
    },

    // Add all items in the **Todos** collection.
    addAll: function () {
      this.$list.html('');
      app.todos.each(this.addOne, this);
    },

    filterOne: function (todo) {
      todo.trigger('visible');
    },

    filterAll: function () {
      app.todos.each(this.filterOne, this);
    },

    // Generate the attributes for a new item.
    newAttributes: function () {
      return {
        title: this.$input.val().trim(),
        order: app.todos.nextOrder(),
        completed: false
      };
    },

    // Typing return in the main input field creates a new **To-do** model
    createOnEnter: function (e) {
      if (e.which === ENTER_KEY && this.$input.val().trim()) {
        app.todos.create(this.newAttributes());
        this.$input.val('');
      }
    },

    // Clear all completed to-do items.
    clearCompleted: function () {
      _.invoke(app.todos.completed(), 'destroy');
      return false;
    },

    toggleAllComplete: function () {
      var completed = this.allCheckbox.checked;

      app.todos.each(function (todo) {
        todo.save({
          completed: completed
        },
        {
          ajaxSync: true
        });
      });
    }
  });

  // Create the `App` in this scope
  new app.AppView();

  // To-do Router
  // ----------
  var TodoRouter = Backbone.Router.extend({
    routes: {
      '*filter': 'setFilter'
    },

    setFilter: function (param) {
      // Set the current filter
      app.TodoFilter = param || '';

      // Trigger a collection filter event 
      // hiding/unhiding of items
      app.todos.trigger('filter');
    }
  });

  app.TodoRouter = new TodoRouter();
  Backbone.history.start();
});

