<!DOCTYPE html>

<html lang="en-US">

    <head>

        <meta charset="utf-8">

    </head>

    <body>

        <h2>Dear, {!!$name!!}</h2>

        <h4>A charge of {!!$amount.$currency!!} has been created from the following account.It will take 4-5 bussiness days to reflect amount in your account.</h4>

        <div>
            <h4>Followings are the bank details: </h4>

            <p>Name: {!!$customer_name!!}</p>

            <p>Email: {!!$customer_email!!}</p>

            <p>Bank Account No.: {!!$account_number!!}</p>
            
        </div>
		<h4>Thanks.</h4>
    </body>

</html>