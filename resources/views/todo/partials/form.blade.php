{{ csrf_field() }}
<div class="form-group">
    <label for="todo-text">Todo</label>
    <input type="text" class="form-control" required name="text" @if(isset($todo) && isset($todo->text)) value="{{ $todo->text }}" @endif id="todo-text" placeholder="Grocery shopping, Call the vet, Pick up glasses...">
</div>
<button type="submit" class="btn btn-success">Save Todo</button>