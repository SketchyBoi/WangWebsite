const validation = new JustValidate('#register');

validation
    .addField("#email", [
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        {
            validator: (value) => () => {
                return fetch("validate_email.php?email=" + encodeURIComponent(value))
                .then(function(response)
                {
                    return response.json();
                })
                .then(function(json)
                {
                    return json.available;
                });
            },
            errorMessage: "Email has already been used"
        }
    ])
    .addField("#password", [
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
    .addField("#confirm", [
        {
            validator: (value, fields) => {
                return value === fields["#password"].elem.value;
            },
            errorMessage: "Passwords should match"
        }
    ])
    .onSuccess((event) => {
        document.getElementById("register").submit();
    });