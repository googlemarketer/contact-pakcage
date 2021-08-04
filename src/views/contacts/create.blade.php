<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Contact-us!</title>
</head>

<body>
    <div class="container">

        <h1>Contact Us!</h1>

        <form action="{{route('contact.store')}}" method="post">
            @csrf
            <div class="input-group flex-nowrap mb-1">
                <span class="input-group-text col-md-1" id="name">Name</span>
                <input name="name" type="text" class="form-control" placeholder="Enter Your fullName" aria-label="Username" aria-describedby="name">
            </div>
            <div class="input-group flex-nowrap mb-1">
                <span class="input-group-text col-md-1" id="email">Email</span>
                <input name="email" type="email" class="form-control" placeholder="Enter Your Email" aria-label="Email" aria-describedby="email">
            </div>
            <div class="input-group flex-nowrap mb-1">
                <span class="input-group-text col-md-1" id="message">Message</span>
                <textarea name="message" id="" cols="30" rows="10" class="form-control">Messages please</textarea>
            </div>
            <button class="btn btn-primary col-md-1 mt-3" type="submit">Submit</button>
        </form>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>
