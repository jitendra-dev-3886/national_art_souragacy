
$(document).ready(function() {
    $('select').on('change', function() {
        var id = this.id;
        var value = this.value;
        var name = this.name;
        var $this = $(this);
        if (value == 'Approve') {
            $.ajax({
                type: "POST",
                url: "update_status.php",
                data: { id: id, value: value, name: name },
                success: function(data) {
                    $this.closest('td').html(data);
                }
            });
        }
    });
});

$(document).ready(function() {
    // Function to initialize DataTable and style buttons
    function initializeTable(tableId) {
        // Check if the table is already initialized
        if (!$.fn.dataTable.isDataTable(tableId)) {
            // Initialize DataTable
            var table = $(tableId).DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true
            });

            // Apply custom styles to the previous and next buttons after table is initialized
            $(tableId).on('draw.dt', function() {
                // Style previous button
                $(tableId + '_previous').css({
                    'width': '114px',          // Width of the previous button
                    'background-color': 'rgb(9 3 28)',  // Blue background
                    'color': '#fff'            // White text
                });
                
                // Style next button
                $(tableId + '_next').css({
                    'width': '114px',          // Width of the next button
                    'background-color': 'rgb(9 3 28)',  // Blue background
                    'color': '#fff'            // White text
                });

                // Add hover effect to previous and next buttons
                $(tableId + '_previous, ' + tableId + '_next').hover(
                    function() {
                        $(this).css({
                            'background-color': 'rgb(12, 9, 39)'  // Slightly darker blue on hover
                        });
                    },
                    function() {
                        $(this).css({
                            'background-color': 'rgb(9, 3, 28)'  // Reset to original color
                        });
                    }
                );
            });
        }
    }

    // Initialize all the tables
    initializeTable('#example1');
    initializeTable('#example5');
    initializeTable('#example6');
    initializeTable('#example3');
    initializeTable('#example4');
});




function handleClick(checkbox) {
    let drpt = checkbox.value;
    let drval = 'drop' + drpt; 
    var dropdown = $('#' + drval);
    var dropdownValue = dropdown.val();

    if (dropdownValue == null || dropdownValue == '') {
        alert("Please select to Assign Value!");
        checkbox.checked = false; 
        dropdown.focus(); 
    }
}


$(document).ready(function() {
document.getElementById('myForm').addEventListener('submit', function(event){
    event.preventDefault(); 
    
    const checkboxes = document.querySelectorAll('input[name="select_check_box"]:checked');
    const selectedValues = Array.from(checkboxes).map(checkbox => checkbox.value);
    //alert(selectedValues.length);
    if (selectedValues.length == 0){
            swal("Warning", "Please select at least one item.", "warning");
            return; // Exit if no checkboxes are selected
    }
    
    if (selectedValues.length > 0) {
        swal({
            title: "Confirm Action",
            text: "Are you sure you want to assign this role?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm) {
            
            if (isConfirm) {
           
                selectedValues.forEach(value => {
                    let drval = 'drop' + value;
                    let dropdown = $('#' + drval).val();
                   
                    const data = dropdown.split("-");
                    let nocid = data[0];
                    //alert(nocid);
                   // alert(nocid);
                    let level_id = data[1];
               //  console.log(level_id);
               //  alert(level_id);
                    //alert(level_id);
                    let userid = data[2];
                    // alert(userid);
                    let serviceid = data[3];
                    //alert(serviceid);

                    $.ajax({
                        url: '/art/ajax-request',
                        type: 'POST',
                        // _token: '{{ csrf_token() }}',
                        data: { app_id: nocid, level_id: level_id, user_id: userid, serviceid: serviceid },
                        headers: {
                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Get CSRF token from the meta tag
                                 },
                        success: function(response) {

                            // alert(response);
                                
                        }
                    });
                    swal("Success!", "Role assigned to users.", "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);  
                });
                 
            } else {
                swal("Cancelled", "No changes were made.", "info");
            }
        });
    } else {
        swal("Warning", "Please select at least one item.", "warning");
    }
});
});

