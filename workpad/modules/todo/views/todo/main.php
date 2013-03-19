<h3>To-do</h3>
<form id="todo-form">
	<input type="text" class="input-large" name="description" placeholder="Add new task..." id="todo-input" />
	<input type="hidden" name="target_date" />
	<input type="text" class="input-small" id="dpicker_target" rel="target_date" placeholder="Due date" />	
	<a href="#" id="todo-submit"><i class="icon-ok-sign"></i></a>
</form>
<div id="todo-container"></div>

<?php $this->load->view('todo/template/todo_item');?>	
<script type="text/javascript">
	$(document).ready(function() {
		var inputView = new TodoInputView({
			model: new TodoModel()
		});

		var userTodoCollection = new UserTodoCollection(<?php echo json_encode($todo->data)?>);
		var todoList = new TodoListView({collection: userTodoCollection, inputView: inputView});

		inputView.on('add', function() {
			userTodoCollection.fetch();
		});
		todoList.renderAll();
        
        var alt = $('input[name="target_date"]');
        $('#dpicker_target').datepicker({
            altField : alt,
            altFormat: "yy-mm-dd",            
        });
	});
</script>