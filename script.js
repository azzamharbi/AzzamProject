$(document).ready(function() {
  // call fetchData function
  fetchData();


  //initialize datatables
  let table = new DataTable("#myTable");


  // function to fetch data from database
  function fetchData() {
    $.ajax({
      url: "server.php?action=fetchData",
      type: "POST",
      dataType: "json",
      success: function(response) {
        var data = response.data;
        table.clear().draw();
        $.each(data, function(index, value) {
          table.row.add([
            value.id,
            value.contract,
            value.client,
            value.contdate,
            value.contenddate,
            value.kamia,
            value.qist,
            value.conttotal,
            value.wayofpay,
            value.status,
            '<Button type="button" class="btn editBtn" value="' + value.id + '"><i class="fa-solid fa-pen-to-square fa-xl"></i></Button>' +
            '<Button type="button" class="btn deleteBtn" value="' + value.id + '"><i class="fa-solid fa-trash fa-xl"></i></Button>' 
          ]).draw(false);
        })
      }
    })
  }

  // function to insert data to database
  $("#insertForm").on("submit", function(e) {
    $("#insertBtn").attr("disabled", "disabled");
    e.preventDefault();
    $.ajax({
      url: "server.php?action=insertData",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(response) {
        var response = JSON.parse(response);
        if (response.statusCode == 200) {
          $("#offcanvasAddUser").offcanvas("hide");
          $("#insertBtn").removeAttr("disabled");
          $("#insertForm")[0].reset();
          
          $("#successToast").toast("show");
          $("#successMsg").html(response.message);
          fetchData();
        } else if(response.statusCode == 500) {
          $("#offcanvasAddUser").offcanvas("hide");
          $("#insertBtn").removeAttr("disabled");
          $("#insertForm")[0].reset();
          
          $("#errorToast").toast("show");
          $("#errorMsg").html(response.message);
        } else if(response.statusCode == 400) {
          $("#insertBtn").removeAttr("disabled");
          $("#errorToast").toast("show");
          $("#errorMsg").html(response.message);
        }
      }
    });
  });


  // function to edit data
  $("#myTable").on("click", ".editBtn", function() {
    var id = $(this).val();
    $.ajax({
      url: "server.php?action=fetchSingle",
      type: "POST",
      dataType: "json",
      data: {
        id: id
      },
      success: function(response) {
        var data = response.data;
        $("#editForm #id").val(data.id);
        $("#editForm input[name='contract']").val(data.contract);
        $("#editForm input[name='client']").val(data.client);
        $("#editForm input[name='contdate']").val(data.contdate);
        $("#editForm input[name='contenddate']").val(data.contenddate);
        $("#editForm input[name='kamia']").val(data.kamia);
        $("#editForm input[name='qist']").val(data.qist);
        $("#editForm input[name='conttotal']").val(data.conttotal);
        $("#editForm select[name='wayofpay']").val(data.wayofpay);                
        if (data.status === "نشط") {
          $("#editForm input[name='status'][value='نشط']").attr("checked", true);
        } else if(data.status === "مخالصة") {
          $("#editForm input[name='status'][value='مخالصة']").attr("checked", true);          
        }
        // show the edit user offcanvas
        $("#offcanvasEditUser").offcanvas("show");
      }
    });
  });



  // function to update data in database
  $("#editForm").on("submit", function(e) {
    $("#editBtn").attr("disabled", "disabled");
    e.preventDefault();
    $.ajax({
      url: "server.php?action=updateData",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(response) {
        var response = JSON.parse(response);
        if (response.statusCode == 200) {
          $("#offcanvasEditUser").offcanvas("hide");
          $("#editBtn").removeAttr("disabled");
          $("#editForm")[0].reset();

          $("#successToast").toast("show");
          $("#successMsg").html(response.message);
          fetchData();
        } else if(response.statusCode == 500) {
          $("#offcanvasEditUser").offcanvas("hide");
          $("#editBtn").removeAttr("disabled");
          $("#editForm")[0].reset();

          $("#errorToast").toast("show");
          $("#errorMsg").html(response.message);
        } else if(response.statusCode == 400) {
          $("#editBtn").removeAttr("disabled");
          $("#errorToast").toast("show");
          $("#errorMsg").html(response.message);
        }
      }
    });
  });



  // function to delete data
  $("#myTable").on("click", ".deleteBtn", function() {
    if(confirm("Are you sure you want to delete this user?")) {
      var id = $(this).val();

      $.ajax({
        url: "server.php?action=deleteData",
        type: "POST",
        dataType: "json",
        data: {
          id,

        },
        success: function(response) {
          if(response.statusCode == 200) {
            fetchData();
            $("#successToast").toast("show");
            $("#successMsg").html(response.message);
          } else if(response.statusCode == 500) {
            $("#errorToast").toast("show");
            $("#errorMsg").html(response.message);
          }
        }
      })
    }
  })

});