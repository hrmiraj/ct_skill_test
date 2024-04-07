<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>CT-Skills</title>
</head>
<body>
    
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6 pt-5 pb-5 mt-5">
                <form action="{{route('save')}}" id="ProductForm" method="POST">
                    @csrf
                    <input type="hidden" id="product_id" name="product_id">
                <div class="form-group mb-3">
                    <label for="">Product Name:</label>
                    <input type="text" class="form-control" id="product_name" placeholder="Enter Product Name" name="product_name">
                </div>
                <div class="form-group mb-3">
                    <label for="">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" placeholder="Enter Quantity" name="quantity">
                </div>
                <div class="form-group mb-3">
                    <label for="">Price per Item:</label>
                    <input type="number" class="form-control" id="price" placeholder="Enter Price Per Item" name="price">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-3"></div>
        </div>

        <div class="row pt-5">
            <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price Per Item</th>
                    <th scope="col">Total Value</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody>
                    
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>{{$product->product_name}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>{{$product->price}}</td>
                            <td>{{$product->quantity * $product->price}}</td>
                            <td>{{$product->created_at}}</td>
                            <td><button type="button" id="{{$key}}" class="btn btn-sm btn-primary editBtn">Edit</button></td>
                        </tr>
                    @endforeach
                  
                </tbody>
              </table>
        </div>
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <script src="https://malsup.github.io/jquery.form.js"></script>
      <script>
        $(document).ready(function(){
            var options = { 
                beforeSubmit:  showRequest,  // pre-submit callback 
                success:       showResponse  // post-submit callback
            }; 
            $('#ProductForm').ajaxForm(options);
            $("tbody").on('click', '.editBtn', function(){
                var product_id = $(this).attr("id");
                var parent = $(this).parent("td").parent('tr');
                var product_name = parent.children('td:nth-child(1)').text();
                var product_quantity = parent.children('td:nth-child(2)').text();
                var product_price = parent.children('td:nth-child(3)').text();
                $('#product_name').val(product_name);
                $('#quantity').val(product_quantity);
                $('#price').val(product_price);
                $('#product_id').val(product_id);
            });                 
        });
        function showRequest(formData, jqForm, options) { 
            var queryString = $.param(formData); 
            return true; 
        } 
        function showResponse(responseText, statusText, xhr, $form)  { 
            var obj = JSON.parse(responseText);
            var products = '';
            $.each(obj, function(i, val) {
                products += '<tr><td>'+val.product_name+'</td><td>'+val.quantity+'</td><td>'+val.price+'</td><td>'+(val.quantity * val.price)+'</td><td>'+val.created_at+'</td><td><button type="button" id="'+i+'" class="btn btn-sm btn-primary editBtn">Edit</button></td></tr>';
            });
            $("tbody").html(products);
            $('#ProductForm')[0].reset();
            $("#product_id").val('');
        }
      </script>
</body>
</html>
