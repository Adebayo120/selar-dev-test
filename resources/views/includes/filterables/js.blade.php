<script>
    let filter_query_string = "";

    $(document).on("change input", ".filter", function (e) {
        e.preventDefault();
        let filter_type = $(this).data("filtertype");
        let table_id = $(this).data("tableid");
        let index = $(this).data("index");
        let value = $(this).val();
        let year_index = $( this ).attr( 'data-yearindex' );
        let year_value = $( `.${year_index}` ).text().trim();
        let pagename = $(this).data("pagename");
        let filter_string = $(`#${table_id}`).attr("data-filter");
        let filter_object = JSON.parse( filter_string );
        if ( index == 'interval' && value.split('to').length != 2 ) {
            return;
        }
        if ( value ) {
            filter_object[ index ] = value; 

            filter_query_string = "";
            $.each( filter_object, function ( index, value ) {
                filter_query_string += filter_query_string != "" ? `&${index}=${value}` : `${index}=${value}`;
            });
            filter_query_string += `&pagename=${pagename}`;
            filter_query_string += `&${year_index}=${year_value}`;
    
            $.ajax({
                url: '{{ url("filter") }}'+`/${filter_type}?${filter_query_string}`, 
                method: 'POST',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                data : {
                    page_name : pagename,
                    table_id : table_id,
                },
                success : function(response) {
                    filter_string = JSON.stringify( filter_object );
                    console.log( filter_string );
                    $(`#${table_id}`).attr("data-filter", filter_string );
                    $(`#${table_id}`).html( response );
                },
                error : function(response) {
                    console.log(response);
                }
            })
        }
    });
</script>