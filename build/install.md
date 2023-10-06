# Config API
```
Thay đổi mật khẩu SQL trong file api/config.php
```

# Config Nginx
Thêm đoạn mã này vào config của trang web
```
location /client/ {
    try_files $uri $uri/client /client/index.php;
}
```

# Create SQL
```
B1 > Thay đổi mật khẩu SQL trong file build/sql/init.sh
B2 > cd build/sql && ./init.sh
```

# Socket Server
```
Install > npm install
Dev > cd socket && npm run dev
Start > cd socket && npm run start
Stop > cd socket && npm run stop
```

# Source Web
```
Dev > cd build/client && npm run dev
Build > cd build/client && npm run build
```

# Prob
Trước khi build client web mới. Cần thay đổi tên trang web và IP máy chủ socket trong file
```
build/client/public/index.html
```

Mỗi Game sẻ có cơ chế gửi vật phẩm khác nhau. Chỉnh sửa tất cả trong thư mục
```
api/game
```


