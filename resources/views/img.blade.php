<!DOCTYPE html>
<html>
<body>

<h2>HTML Forms</h2>

<form action="">

  <label for="lname">email:</label><br>
  <input type="text" id="email" name="email" value=""><br><br>
  <input type="submit" value="Submit">
</form> 

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

<script>
  
$(document).ready(function() {
    // Set up jQuery validation
    $('form').validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: "{{route('check_email')}}",
                    type: 'post',
                    data: {
                      "_token": "{{ csrf_token() }}",
                        email: function() {
                            return $('#email').val();
                        }
                    }
                }
            }
        },
        messages: {
            email: {
                remote: 'This email is already exist.'
            }
        },
        submitHandler: function(form) {
            // Submit the form using AJAX
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    // Handle the success response
                    console.log(response);
                },
                error: function(xhr) {
                    // Handle the error response
                    console.log(xhr.responseText);
                }
            });
        }
    });
});
</script>
</body>
</html>
