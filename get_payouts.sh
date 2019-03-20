username=""
password=""
data="{\"email\":\"$username\",\"password\":\"$password\",\"returnUrl\":\"\"}"
json=$(curl -s -X 'POST' 'https://www.intigriti.com/authentication/login' -H 'Content-Type: application/json;charset=utf-8' --data-binary $data)
token=`echo $json | jq -r ".token"`
output=`curl -s 'https://api.intigriti.com/api/payout' -H "Authorization: Bearer $token"`
echo $output
