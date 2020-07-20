<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Reciept</title>

    <style>

@media print {
  body * {
    visibility: hidden;
  }
  #pos-invoice, #pos-invoice * {
    visibility: visible;
  }
  #pos-invoice {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: auto;
    padding: 2px;
    border: none;
  }
}

#pos-invoice{
    height:115mm;
}
   
.name-shop {
    font-size: 20px;
    font-weight: 600;
}

.thead{
    font-size: 18px;
    font-weight: 600;
}

.tbody{
    font-size: 16px;
    font-weight: 800;
}

 #order-text{
            margin-top: -10px;
        }
        .table-total{
            margin-top: -14px;
        }
    </style>
    

</head>
<body>  
                    




                    <div class="mt-5">
                        <button onclick="printSr()">werwer</button></div>











        <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>    

        <script>
            function printSr(){
                window.print();
            }
        </script>

</body>
</html>