<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

  <div class="form-group">
    <label for="exampleInputEmail1">Title</label>
    <input type="title" class="form-control" id="title" aria-describedby="emailHelp">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Author</label>
    <input type="author" class="form-control" id="author" aria-describedby="emailHelp">
  </div>
  <button type="submit" class="btn btn-primary" id="insert">Submit</button>

  <table id="booktable">
    <tbody>
    <tr>
      <td id="title"></td>
      <td id="author"></td>
    </tr>
  </tbody>
  </table>

<script type="text/javascript">
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  $(document).ready(function(){

  // Fetch records
  fetchRecords();

  // Add record
  $('#insert').click(function(){

    var title = $('#title').val();
    var author = $('#author').val();
    // var email = $('#email').val();

    if(title != '' && author != ''){
      $.ajax({
        url: 'insert',
        type: 'post',
        data: {_token: CSRF_TOKEN,title: title,author: author},
      });
      alert('Data saved successfully');
    }else{
      alert('Fill all fields');
    }
  });
});

  function fetchRecords(){
  $.ajax({
    url: 'books',
    type: 'get',
    dataType: 'json',
    success: function(response){

      var len = 0;
      $('#booktable tbody tr:not(:first)').empty(); // Empty <tbody>
      if(response['data'] != null){
        len = response['data'].length;
      }

      if(len > 0){
        for(var i=0; i<len; i++){

          var id = response['data'][i].id;
          var title = response['data'][i].title;
          var author = response['data'][i].author;

          var tr_str = "<tr>" +
          "<td align='center'>" + title + "</td>" + 
          "<td align='center'>" + author + "</td>" + 
          
          "<td align='center'><input type='button' value='Update' class='update' data-id='"+id+"' ><input type='button' value='Delete' class='delete' data-id='"+id+"' ></td>"+
          "</tr>";

          $("#booktable tbody").append(tr_str);

        }
      }else{
        var tr_str = "<tr class='norecord'>" +
        "<td align='center' colspan='4'>No record found.</td>" +
        "</tr>";

        $("#booktable tbody").append(tr_str);
        // $('tbody').html(data.table_data);
      }

    }
  });
}

</script>