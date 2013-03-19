<script type="template/javascript" id="goal-edit-template">    
    <form class="form-horizontal">
        <div class="control-group">
            <label class="control-label" for="title">Title</label>
            <div class="controls">
                <input type="text" id="title" name="title" placeholder="Title" value="<%= title %>">
                <span id="title"></span>
            </div>
        </div>    
        
        <div class="control-group">
            <label class="control-label" for="description">Description</label>
            <div class="controls">
                <textarea id="description" name="description" placeholder="Description"><%= description %></textarea>
                <span id="description"></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="target">Target Date</label>
            <div class="controls">
                <input type="hidden" name="target" value="<%= target %>"/>
                <input type="text" class="datepicker input-medium" rel="target" placeholder="Pick date"/>
                <span id="target"></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="parent_id">Related To</label>
            <div class="controls">
                <select name="parent_id" placeholder="Select a parent goal">
                    <option value=""></option>
                    <% _.each(goals, function(goal) { 
                        if (goal.id != goal_id) {
                        %>
                        <option value="<%= goal.id %>"
                        <% if (goal.id == parent_id) { %> selected <% } %>
                        >
                            <%= goal.get('title')%> 
                        </option>
                    <% }
                }); %>
                </select>
            </div>
        </div>            
    </form>
</script>