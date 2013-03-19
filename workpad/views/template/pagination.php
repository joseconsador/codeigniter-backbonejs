
    <!-- Pagination template -->
    <script type="text/html" id="tmpServerPagination">
        <div class="btn-group hidden-phone">               
            <% if (firstPage != currentPage) { %>
                <a class="serverfirst btn">First</a>
            <% } %>

            <% if (currentPage > firstPage) { %>
                <a class="serverprevious btn">&lt;</a>
            <% }else{ %>
                <a class="btn disabled">&lt;</a>
            <% }%>

            <% 
            range = 3;
            range_min = (range % 2 == 0) ? (range / 2) - 1 : (range - 1) / 2;
            range_max = (range % 2 == 0) ? range_min + 1 : range_min;
            page_min = currentPage- range_min;
            page_max = currentPage+ range_max;                        

            page_min = (page_min < 1) ? 1 : page_min;
            page_max = (page_max < (page_min + range - 1)) ? page_min + range - 1 : page_max;
            if (page_max > totalPages) {
                page_min = (page_min > 1) ? totalPages - range + 1 : 1;
                page_max = totalPages;
            }

            page_min = (page_min < 1) ? 1 : page_min;

            for (p = page_min;p <= page_max;p++) {
            %>
                <% if (p == currentPage) { %>
                    <a class="page selected btn disabled"><%= p %></a>
                <% } else { %>
                    <a class="page btn"><%= p %></a>
                <% } %> 
            <%  
            }%>

            <% if (currentPage < totalPages) { %>
                <a class="servernext btn">&gt;</a>
            <% } %>

            <% if (lastPage != currentPage) { %>
                <a class="serverlast btn">Last</a>
            <% } %>                    
            <div class="btn-group pull-right">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                &nbsp;
                <span class="caret"></span>
                </a>
                <ul class="dropdown-menu serverhowmany">
                    <li><a href="#" class="selected">5</a></li>                        
                    <li><a href="#" class="">10</a></li>                        
                    <li><a href="#" class="">25</a></li>                        
                    <li><a href="#" class="">50</a></li>                        
                    <li><a href="#" class="">100</a></li>
                </ul>
            </div>        
        </div>                      
    </script>
    <!--# end templates -->

<!-- Pagination template -->
<script type="text/html" id="tmpServerPagination2">
    <div class="pagination hidden-phone">               
        <ul>
        <% if (firstPage != currentPage - 1) { %>
            <li><a class="serverfirst" href="#">First</a></li>
        <% } %>

        <% if (currentPage > firstPage) { %>
            <li><a class="serverprevious" href="#">&lt;</a></li>
        <% }else{ %>
            <li class="disabled"><a href="#">&lt;</a></li>
        <% }%>

        <% 
        range = 3;
        range_min = (range % 2 == 0) ? (range / 2) - 1 : (range - 1) / 2;
        range_max = (range % 2 == 0) ? range_min + 1 : range_min;
        page_min = currentPage- range_min;
        page_max = currentPage+ range_max;                        

        page_min = (page_min < 1) ? 1 : page_min;
        page_max = (page_max < (page_min + range - 1)) ? page_min + range - 1 : page_max;
        if (page_max > totalPages) {
            page_min = (page_min > 1) ? totalPages - range + 1 : 1;
            page_max = totalPages;
        }

        page_min = (page_min < 1) ? 1 : page_min;

        for (p = page_min;p <= page_max;p++) {
        %>
            <% if (p == currentPage) { %>
                <li class="active selected disabled"><a class="page" href="#"><%= p %></a></li>
            <% } else { %>
                <li><a class="page" href="#"><%= p %></a></li>
            <% } %> 
        <%  
        }%>

        <% if (currentPage < totalPages) { %>
            <li><a class="servernext" href="#">&gt;</a></li>
        <% } %>

        <% if (lastPage != currentPage) { %>
            <li><a class="serverlast" href="#">Last</a></li>
        <% } %>                               
        </ul>             
    </div>                      
</script>

<!-- <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            Show
            <span class="caret"></span>
            </button>
            <ul class="dropdown-menu serverhowmany">
                <li><a href="#" class="selected">5</a></li>                        
                <li><a href="#" class="">10</a></li>                        
                <li><a href="#" class="">25</a></li>                        
                <li><a href="#" class="">50</a></li>                        
                <li><a href="#" class="">100</a></li>
            </ul>
        </div> -->