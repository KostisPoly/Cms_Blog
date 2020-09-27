    $(document).foundation();

    $( "#datepicker" ).datepicker();

    $('#refreshIcon').on('click', function(){
        //set to true to avoid cache reload document?
        location.reload();
    });

    $('#toggleButton').on('click', function(){
        $('.allPosts, .draftPosts, .allComments, .draftComments, .allUsers, .draftUsers').toggleClass('active');
        $('#allPosts, #draftPosts, #allComments, #draftComments, #allUsers, #draftUsers').toggleClass('hide');
    });

    $('.adminIcon').on('click', function(){
        
        var toggleIcon = $(this).attr('name') == 'checkmark-circle-outline' ? 'close-circle-outline' : 'checkmark-circle-outline';
        $(this).attr('name', toggleIcon);
        var toggleVal = $('#isadmin').val() == '1' ? '0' : '1';
        $('#isadmin').val(toggleVal);
    });

    $('.actionIcon').on('click', function(){
        
        var cells = $(this).parent().siblings();
        var data = [];
        var tdID = $(this).parent().attr('id');
        
        $.each(cells, function(){
                
                var obj = {}
                obj[this.className] = $(this).html();    
                data.push(obj);
                
        });
        window.modalData = data;
        console.log(modalData);
        var popup = new Foundation.Reveal($('#exampleModal2'));
        popup.open();
        
        if (tdID.substring(0,4) == 'post') {
        
            var postID = tdID.split("post")[1];
            
            $('#exampleModal2').find('input[name=edit]').val(postID);
            $('#exampleModal2').find('input[name=title]').val(modalData[2]['post_title']);
            $('#exampleModal2').find('input[name=author]').val(modalData[3]['post_author']);
            $('#datepicker').val(modalData[4]['post_date'])
            $('#exampleModal2').find('textarea[name=content]').val(modalData[6]['post_content']);
            $('#exampleModal2').find('input[name=tags]').val(modalData[8]['post_tags']);
            $('#exampleModal2').find('select[name=category]').val(modalData[0]['hide post_category']);
            $('#exampleModal2').find('select[name=status]').val(modalData[9]['post_status']);
        } else if (tdID.substring(0,4) == 'user') {
            var userID = tdID.split("user")[1];

            $('#exampleModal2').find('input[name=edit]').val(userID);
            $('#exampleModal2').find('input[name=username]').val(modalData[1]['us_username']);
            $('#exampleModal2').find('input[name=password]').val(modalData[2]['us_password']);
            $('#exampleModal2').find('input[name=firstname]').val(modalData[3]['us_firstname']);
            $('#exampleModal2').find('input[name=lastname]').val(modalData[4]['us_lastname']);
            $('#exampleModal2').find('input[name=email]').val(modalData[5]['us_email']);
            $('#exampleModal2').find('select[name=role]').val(modalData[6]['us_role']);
            $('#exampleModal2').find('input[name=isadmin]').val(modalData[7]['us_isadmin']);
            var adminIcon = modalData[7]['us_isadmin'] == 1 ? 'checkmark-circle-outline' : 'close-circle-outline' ;
            $('#exampleModal2').find('.adminIcon').attr('name', adminIcon);

        }else if (tdID.substring(0,4) == 'cate') {
            var categoryID = tdID.split("cate")[1];

            $('#exampleModal2').find('input[name=edit]').val(categoryID);
            $('#exampleModal2').find('input[name=title]').val(modalData[0]['cat_title']);
            $('#exampleModal2').find('select[name=category]').val(modalData[1]['cat_parent_cat']);
        } else {
            var commentID = tdID.split("comment")[1];
            
            $('#exampleModal2').find('input[name=edit]').val(commentID);
            $('#exampleModal2').find('input[name=author]').val(modalData[1]['com_author']);
            $('#exampleModal2').find('input[name=email]').val(modalData[2]['com_email']);
            $('#exampleModal2').find('textarea[name=content]').val(modalData[3]['com_content']);
            $('#exampleModal2').find('input[name=date]').val(modalData[4]['com_date']);
            $('#exampleModal2').find('select[name=status]').val(modalData[5]['com_status']);
        }
    });