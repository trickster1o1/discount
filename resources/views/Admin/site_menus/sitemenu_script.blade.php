<script type="text/javascript">
    $(document).ready(function() {
        $('#category-p').hide();
        $('#sub_category-p').hide();
        $('#topic-p').hide();
        $('#external_url_p').hide();
        change_in_link_type();
        change_in_category();
        getContent();

        $('#link_type').on('change',function(){
            change_in_link_type();
            change_in_category();
            getContent();
        });
        $('select[name="category"]').on('change',function(){
            change_in_category();
            getContent();
        });
        $('#sub_category_list').on('change',function(){
            getContent();
        });
        $('#topic_list').on('change',function(){
            topic_change();
        });

        $('select[name="parent"]').on('change',function(){
            var location = $('select[name="parent"] option:selected').attr('data-location');
            if(location != ''){
                $('select[name="location"]').val(location).trigger('change');
            }
        });


    });

    function hide_show(){
        var link_type = $('#link_type').val();
        $('#sub_category-p').hide();
        $('#category-p').hide();
        $('#topic-p').hide();
        $('#external_url_p').hide();
        if(link_type == 'none'){
            $('#sub_category-p').hide();
            $('#category-p').hide();
            $('#topic-p').hide();
            $('#external_url_p').hide();
        }else if(link_type == 'internal_link'){
            $('#topic-p').show();
        }else if(link_type == 'external_url'){
            $('#external_url_p').show();
        }else{
            $('#sub_category-p').show();
            $('#category-p').show();
            $('#topic-p').show();
        }
    }

    function change_in_link_type(){
        var link_type = $('#link_type').val();
        if(link_type == 'none' || link_type == 'external_url'){
            hide_show();
        }else{
            var selected_category = $('#old_category').val();
            $.ajax({
                data:"ctslug="+link_type+"&selected_category="+selected_category+"&_token={{ csrf_token() }}",
                type:"POST",
                url:"/admin/dashboard/getcategory",
                async: false,
                success:function(response){
                    $('#category_list').html(response.html);
                    hide_show();
                }
            });
        }
    }

    function change_in_category(){
        var category = $('#category_list').val();
        var selected = $('#old_sub_category').val();
        $.ajax({
            data:"cid="+category+'&selected='+selected+'&_token={{csrf_token()}}'+"&selectoption=1",
            type:"POST",
            url:"/admin/dashboard/getsubcategory",
            async: false,
            success:function(response){
                hide_show();
                $('#sub_category_list').html(response.html);
            }
        })
    }

    function getContent(){
        var subcategory = $('#sub_category_list').val();
        var link_type = $('#link_type').val();
        var old_topic = $('#old_topic').val();
        $.ajax({
            url:'/getopic',
            data:"sid="+subcategory+"&old_topic="+old_topic+"&lid="+link_type+"&_token={{ csrf_token() }}",
            type:"POST",
            async: false,
            success:function(response){
                $('#topic_list').html(response.html);
                hide_show();
            }
        });
    }

    function topic_change(){
        var topic = $('#topic_list option:selected').text();
        if($.trim(topic).length > 0){
          $('#title').val(topic);  
        }        
    }
</script>