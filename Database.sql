CREATE SCHEMA `ashion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

create table if not exists product_category(
    id bigint not null primary key AUTO_INCREMENT,
    title varchar(75) not null unique,
    detail text null,
    created_at datetime not null,
    modified_at datetime null DEFAULT null,
    deleted_at datetime null DEFAULT null
);

create table if not exists product_inventory (
    id bigint not null primary key AUTO_INCREMENT,
    quantity json not null,
    created_at datetime not null,
    modified_at datetime null DEFAULT null,
    deleted_at datetime null DEFAULT null
);

    create table if not exists discount (
        id bigint not null primary key AUTO_INCREMENT,
        title varchar(75) not null unique,
        detail text null,
        discount_percent decimal not null,
        active boolean not null,
        created_at datetime not null,
        modified_at datetime null DEFAULT null,
        deleted_at datetime null DEFAULT null
    );

create table if not exists product (
    id bigint not null AUTO_INCREMENT PRIMARY KEY,
    title varchar(75) not null unique,
    detail text null,
    sku varchar(100) not null,
    category_id bigint not null,
    inventory_id bigint not null,
    price float not null DEFAULT 0,
    discount_id bigint not null,
    created_at datetime not null DEFAULT NOW(),
    modified_at datetime null DEFAULT null,
    deleted_at datetime null DEFAULT null,
    stock_price float null,
    color text,
    size text,
    available_color text,
    available_size text,
    ranking float DEFAULT 0,
    pictures varchar(100) not null,
    promotions varchar(100),
    foreign key (category_id) references product_category(id),
    foreign key (inventory_id) references product_inventory(id),
    foreign key (discount_id) references discount(id)
);

create table if not exists user (
    id bigint not null AUTO_INCREMENT primary key,
    password text not null,
    firstName varchar(20) not null,
    lastName varchar(20) not null,
    telephone varchar(11) not null unique,
    email varchar(30) not null unique,
    created_at datetime not null,
    modified_at datetime null DEFAULT null
);

create table if not exists shopping_session (
    id bigint not null AUTO_INCREMENT primary key,
    user_id bigint not null,
    total float not null,
    created_at datetime not null,
    modified_at datetime null DEFAULT null,
    foreign key (user_id) references users(id)
);

create table if not exists cart_item (
    id bigint not null AUTO_INCREMENT primary key,
    session_id bigint not null,
    product_id bigint not null,
    quantity int not null,
    created_at datetime not null,
    modified_at datetime null DEFAULT null
);

create table if not exists order_details (
    id bigint not null AUTO_INCREMENT primary key,
    user_id bigint not null,
    total float not null,
    peyment_id bigint null,
    created_at datetime not null,
    modified_at datetime null DEFAULT null,
    foreign key (user_id) references user(id),
    foreign key (peyment_id) references peyment_details(id)
);

create table if not exists peyment_details (
    id bigint not null AUTO_INCREMENT primary key,
    order_id bigint not null,
    amount int not null,
    providers varchar(20) not null,
    stat boolean,
    created_at datetime not null,
    modified_at datetime null DEFAULT null,
    foreign key (order_id) references order_details(id)
);

create table if not exists order_items (
    id bigint not null AUTO_INCREMENT primary key,
    order_id bigint not null,
    product_id bigint not null,
    quantity int not null,
    created_at datetime not null,
    modified_at datetime null DEFAULT null,
    foreign key (order_id) references order_details(id),
    foreign key (product_id) references product(id)
);

create table if not exists user_address (
    id bigint not null AUTO_INCREMENT primary key,
    address_line varchar(50) not null,
    province varchar(20) not null,
    postal_code decimal not null,
    city varchar(20) not null,
    telephone varchar(10),
    mobile varchar(10) not null
);

create table if not exists user_payment (
    id bigint not null AUTO_INCREMENT primary key,
    user_id bigint not null,
    payment_type tinyint(4) not null,
    providers varchar(20) not null,
    tracking_no int not null,
    expiry datetime,
    foreign key (user_id) references user(id)
);