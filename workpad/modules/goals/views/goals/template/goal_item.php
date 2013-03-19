<script type="template/javascript" id="goal-list-item-template">
    <%
        target = Date.createFromMysql(target);

        if (points == 0) {
            progress = 0;
        } else {
            progress = (points_earned / points) * 100;
        }
    %>

    <div class="pull-right">
      <!-- h3><%= progress %>% in progress</h3 -->
        <%
        rating_system = new StarRating({
            name: 'goal-point',
            id: goal_id,
            max_points: 100,
            num_options: 5,
            default: points_earned
        });

        print(rating_system.render());
        %>
    </div>
    <h3><a href="#" id="edit-goal-<%= goal_id %>"><%= $('<div>' + title + '</div>').text() %></a> <span class="label label-success"><%= points %> pts</span></h3>
    <p>           
        <%
            if (!_.isEmpty(involved)) {
                print('With ');
                _.each(involved, function(i) {
                    print('<a class="label label-info">' + i.full_name + '</a> ');
                });
            }
        %>
        due on 
        <i><%= monthNames[target.getMonth()] %> <%= target.getDate() %>, <%= target.getUTCFullYear() %></i>
    </p>

    <table class="table table-condensed">
        <thead>
            <tr>
              <% if (is_owner) { %><th>&nbsp;</th><% } %>
              <th>Objective</th>                
              <th>Points</th>
              <th>Assigned To</th>
              <th>Due Date</th>
            </tr>
        </thead>
        <tbody></tbody>        
    </table>

    <% if (is_owner) { %>
        <button class="btn btn-primary" id="add-objective-<%= goal_id %>">Add Objective</button>
    <% } %>

    <% if (has_children) { %>
        <button class="btn show-children">Show Child Goals</button>
    <% } %>    
</script>

<script type="template/javascript" id="goal-objective-template">
    <% if (is_owner) { %>
    <td>                
        <div class="btn-group">
            <button class="btn objective-delete" data-toggle="modal" href="#">
                <i class="icon-remove"></i>
            </button>
            <a href="#" class="btn objective-edit" data-toggle="modal" href="#">
                <i class="icon-pencil"></i>
            </a>
        </div> 
    </td>
    <% } %>
    <td><%= $('<div>' + title + '</div>').text() %></td>
    <td>
        <%
        rating_system = new StarRating({
            name: 'objective-point',
            id: goal_item_id,
            max_points: 100,
            num_options: 5,
            default: points_earned
        });

        print(rating_system.render());
        %>
    </td>
    <td>
        <% _.each(involved, function(i) { %>
            <a class="label label-info"><%= i.full_name %></a>
        <%  }); %>
    </td>
    <td><%= $.datepicker.formatDate('D, M d', Date.createFromMysql(target_date)) %></td>
</script>