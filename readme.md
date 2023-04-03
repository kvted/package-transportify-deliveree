# Transportify Deliveree Package

[![main](https://github.com/multisyscorp/package-open-fabric/actions/workflows/main.yml/badge.svg)](https://github.com/multisyscorp/package-open-fabric/actions/workflows/main.yml)
[![codecov](https://codecov.io/gh/multisyscorp/package-open-fabric/branch/main/graph/badge.svg?token=SAZLNWPDWL)](https://codecov.io/gh/multisyscorp/package-open-fabric)

---
## Contents

1. [Overview](#overview)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Usage](#usage)
5. [Testing](#testing)
6. [Additional Details](#additional-details)

## Overview

Package for Open Fabric payment method.

## Installation
1. Add this to your `composer.json`
    ```json
    {
        "repositories": [{
            "type": "composer",
            "url": "https://repo.geekhives.com"
        }]
    }
    ```
2. Install via composer
   ```
   composer require multisyscorp/transportify-deliveree
   ```

## Configuration

- Add this on /bootstrap/app.php:

   ```php
   $app->register(MsysCorp\TransportifyDeliveree\ServiceProvider::class);
   ```

- Copy /config/msyscorp_transportify_deliveree.php to your project config and Add this on /bootstrap/app.php:
   ```php
   $app->configure('msyscorp_transportify_deliveree');
   ```
- Then set env values on your .env file.

## Usage
### Get Delivery Quote

Sample minimum payload required:<br>

```php
$payload = new DeliveryQuote();
$payload->setTimeType(TimeType::NOW);
$payload->setPickupTime(now());
$payload->setVehicleTypeId('21');
$payload->setPacks([
    [
        'dimensions' => [1,2,3],
        'weigth' => 100,
        'quantity' => 2
    ],
    [
        'dimensions' => [2,2,5],
        'weigth' => 20,
        'quantity' => 1
    ]
]);
$payload->setLocations([
    [
        'address' => 'Sample address',
        'latitude' => -6.2608232,
        'longitude' => 106.7884168
    ],
    [
        'address' => 'Test address',
        'latitude' => -6.248446679393533,
        'longitude' => 106.84431951392108,
        'recipient_name' => 'Test name',
        'recipient_phone' => '+84903856534',
        'note' => 'Office test tower, 19th floor'
    ]
]);
$payload->setExtraServices([
    [
        'extra_requirement_id' => 140,
        'selected_amount' => 1
    ],
    [
        'extra_requirement_id' => 416,
        'selected_amount' => 1,
        'extra_requirement_pricing_id' => 2146
    ]
]);

$response = TransportifyDeliveree::createDeliveryQuote($payload);
```

Sample response and format:
```php
 {
    "data": [
        {
            "vehicle_type_id": 1,
            "vehicle_type_name": "Motorcycle",
            "time_type":"now",
            "total_fees": 500,
            "currency": "Rp",
            "total_distance": 0.0,
            "vehicle_type": {
                "id": 21,
                "name": "Double Engkel Pickup",
                "cargo_length": 300.0,
                "cargo_height": 200.0,
                "cargo_width": 200.0,
                "cargo_weight": 2000.0,
                "cargo_cubic_meter": 10.0,
                "minimum_pickup_time": "2021-09-24T12:36:28.538+07:00",
                "quick_choices": [
                    {
                        "id": 272,
                        "schedule_time": 5,
                        "time_type": "now"
                    }
                ]
            }
        }
    ]
}
```
### Create Delivery

Sample minimum payload required:<br>

```php
$payload = new Delivery();
$payload->setTimeType(TimeType::NOW);
$payload->setPickupTime(now());
$payload->setLocations([
    [
        'address' => 'Sample address',
        'latitude' => -6.2608232,
        'longitude' => 106.7884168
    ],
    [
        'address' => 'Test address',
        'latitude' => -6.248446679393533,
        'longitude' => 106.84431951392108,
        'recipient_name' => 'Test name',
        'recipient_phone' => '+84903856534',
        'note' => 'Office test tower, 19th floor'
    ]
]);

$response = TransportifyDeliveree::createDelivery($payload);
```

Sample response and format:
```php
{
    "id": 100,
    "customer_id": 22,
    "driver_id": 403,
    "vehicle_type_id": 1,
    "company_id": 33,
    "time_type": "now",
    "status": "delivery_in_progress",
    "note": "Just a note",
    "total_fees": 500,
    "currency": "Rp",
    "tracking_url": "https://webapp.deliveree.com/...",
    "job_order_number": "66666",
    "created_at": "2016-01-29T01:35:08Z",
    "eta_from_driver_to_pickup": 1800,
    "distance_from_driver_to_pickup": 10.5,
    "pickup_time": "2021-07-01T18:38:17+07:00",
    "completed_at": null,
    "driver": null,
    "vehicle": {
        "vehicle_attributes": {
            "plate_number": null
        }
    },
    "locations": [
        {
            "id": 707438,
            "name": "Jl. Sultan Iskandar Muda No.21, Arteri Pondok Indah, Pd. Pinang, Kby. Lama, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta, Indonesia",
            "driver_note": null,
            "note": "Second floor, room 609",
            "recipient_name": "Duke",
            "status": "",
            "failed_delivery_reason": "",
            "position_trackings": [],
            "proof_of_delivery_photos": [],
            "signature_url": null
        },
        {
            "id": 707439,
            "name": "Gedung Inti Sentra, Jl. Taman Kemang, RT.14/RW.1, Bangka, Mampang Prpt., Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta, Indonesia",
            "driver_note": null,
            "note": "First floor, right room.",
            "recipient_name": "Duke",
            "status": "",
            "failed_delivery_reason": "",
            "position_trackings": [],
            "proof_of_delivery_photos": [],
            "signature_url": null
        },
        {
            "id": 707440,
            "name": "Lavenue Apartemen, Jl. Ps. Minggu Raya, RT.7/RW.2, Pancoran, South Jakarta City, Jakarta, Indonesia",
            "driver_note": null,
            "note": "Office tower, 19th floor",
            "recipient_name": "Duke",
            "status": "",
            "failed_delivery_reason": "",
            "position_trackings": [],
            "proof_of_delivery_photos": [],
            "signature_url": null
        }
    ],
    "require_signatures": true,
    "booking_extra_requirements": [
        {
            "selected_amount": 1,
            "extra_requirement_id": 140,
            "name": "Extra Helper",
            "unit_price": 50000,
            "display_level_price": null,
            "display_fees": "Free",
            "display_fees_without_currency": "Free",
            "position": 1,
            "is_insurance": false
        },
        {
            "selected_amount": 1,
            "extra_requirement_id": 416,
            "name": "Goods Insurance",
            "unit_price": 0.0,
            "display_level_price": "Rp 1.000.000.000",
            "display_fees": "Free",
            "display_fees_without_currency": "Free",
            "position": 1,
            "is_insurance": true
        }
    ]
}

```

### Fetch Delivery Details
To fetch Delivery Details, you need: <br>
- id - `id` response from [Create Delivery](#Create-Delivery)

```php
$response = TransportifyDeliveree::fetchDeliveryDetails('<id>');
```
Sample response and format:
```php
{
    "id": 100,
    "customer_id": 22,
    "driver_id": 403,
    "driver": {
        "id": 403,
        "name": "Duke the driver",
        "phone": "+84903398399",
        "driver_image_url": "https://webapp.deliveree.com/...",
        "last_known_position_lat": 10.767930,
        "last_known_position_lng": 106.696440
    },
    "vehicle_type_id": 1,
    "company_id": 33,
    "time_type": "now",
    "status": "delivery_in_progress",
    "note": "Just a note",
    "total_fees": 500,
    "currency": "Rp",
    "tracking_url": "https://webapp.deliveree.com/...",
    "job_order_number": "66666",
    "eta_from_driver_to_pickup": 60,
    "distance_from_driver_to_pickup": 1.2,
    "created_at": "2016-01-29T01:35:08Z",
    "pickup_time": "2016-02-01T01:36:08Z",
    "completed_at": null,
    "vehicle": {
        "vehicle_attributes": {
            "plate_number": "SPIL Blue 40ft - 000.01"
        }
    },
    "locations": [
        {
            "address": "Jl. Sultan Iskandar Muda No.21, Arteri Pondok Indah, Pd. Pinang, Kby. Lama, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta, Indonesia",
            "latitude": -6.2608232,
            "longitude": 106.7884168,
            "recipient_name": "Duke",
            "recipient_phone": "+84903398399",
            "note": "Second floor, room 609",
            "status": "",
            "failed_delivery_reason": "",
            "position_trackings": [
                {
                    "id": 1,
                    "latitude": -6.272444,
                    "longitude": 106.805534,
                    "tracked_at": "2016-01-29T03:35:08Z",
                    "tracking_type": "location_have_arrived"
                },
                {
                    "id": 2,
                    "latitude": -6.272444,
                    "longitude": 106.805534,
                    "tracked_at": "2016-01-29T03:55:08Z",
                    "tracking_type": "location_accept_delivery"
                }
            ],
            "proof_of_delivery_photos": [
                {
                    "photo_type": "proof_of_delivery",
                    "photo_name": "Proof of delivery",
                    "image_url": "https://webapp.deliveree.com/...",
                    "image_content_type": "image/png"
                },
                {
                    "photo_type": "proof_of_delivery",
                    "photo_name": "Proof of delivery",
                    "image_url": "https://webapp.deliveree.com/...",
                    "image_content_type": "image/png"
                }
            ],
            "signature_url": "https://webapp.deliveree.com/..."
        },
        {
            "address": "Gedung Inti Sentra, Jl. Taman Kemang, RT.14/RW.1, Bangka, Mampang Prpt., Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta, Indonesia",
            "latitude": -6.2608232,
            "longitude": 106.7884168,
            "recipient_name": "Nam",
            "recipient_phone": "+84903856534",
            "note": "First floor, right room.",
            "status": "Failed",
            "failed_delivery_reason": "Recipient rejected",
            "need_cod": true,
            "cod_note": "You need to get money from Nam",
            "cod_invoice_fees": 5000,
            "need_pod":true,
            "pod_note": "You need to ...",
            "position_trackings": [
                {
                    "id": 3,
                    "latitude": -1.003189,
                    "longitude": 101.972332,
                    "tracked_at": "2016-01-29T05:35:08Z",
                    "tracking_type": "location_have_arrived"
                },
                {
                    "id": 4,
                    "latitude": -1.003189,
                    "longitude": 101.972332,
                    "tracked_at": "2016-01-29T05:55:08Z",
                    "tracking_type": "location_accept_delivery"
                }
            ],
            "proof_of_delivery_photos": [
                {
                    "photo_type": "proof_of_delivery",
                    "photo_name": "Proof of delivery",
                    "image_url": "https://webapp.deliveree.com/...",
                    "image_content_type": "image/png"
                },
                {
                    "photo_type": "proof_of_delivery",
                    "photo_name": "Proof of delivery",
                    "image_url": "https://webapp.deliveree.com/...",
                    "image_content_type": "image/png"
                }
            ],
            "signature_url": "https://webapp.deliveree.com/..."
        },
        {
            "address": "Lavenue Apartemen, Jl. Ps. Minggu Raya, RT.7/RW.2, Pancoran, South Jakarta City, Jakarta, Indonesia",
            "latitude": -6.248446679393533,
            "longitude": 106.84431951392108,
            "recipient_name": "Duke",
            "recipient_phone": "+84903856534",
            "note": "Office tower, 19th floor",
            "status": "",
            "failed_delivery_reason": "",
            "position_trackings": [
                {
                    "id": 3,
                    "latitude": -1.003189,
                    "longitude": 101.972332,
                    "tracked_at": "2016-01-29T05:35:08Z",
                    "tracking_type": "location_have_arrived"
                },
                {
                    "id": 4,
                    "latitude": -1.003189,
                    "longitude": 101.972332,
                    "tracked_at": "2016-01-29T05:55:08Z",
                    "tracking_type": "location_accept_delivery"
                }
            ],
            "proof_of_delivery_photos": [
                {
                    "photo_type": "proof_of_delivery",
                    "photo_name": "Proof of delivery",
                    "image_url": "https://webapp.deliveree.com/...",
                    "image_content_type": "image/png"
                },
                {
                    "photo_type": "proof_of_delivery",
                    "photo_name": "Proof of delivery",
                    "image_url": "https://webapp.deliveree.com/...",
                    "image_content_type": "image/png"
                }
            ],
            "signature_url": "https://webapp.deliveree.com/..."
        }
    ],
    "require_signatures": true,
    "booking_extra_requirements": [
        {
            "selected_amount": 1,
            "extra_requirement_id": 140,
            "name": "Extra Helper",
            "unit_price": 50000,
            "display_level_price": null,
            "display_fees": "Free",
            "display_fees_without_currency": "Free",
            "position": 1,
            "is_insurance": false
        },
        {
            "selected_amount": 1,
            "extra_requirement_id": 416,
            "name": "Goods Insurance",
            "unit_price": 0.0,
            "display_level_price": "Rp 1.000.000.000",
            "display_fees": "Free",
            "display_fees_without_currency": "Free",
            "position": 1,
            "is_insurance": true
        }
    ]
}
```

<br>

### Cancel Delivery

To Cancel Delivery, you need: <br>
- id - `id` response from [Create Delivery](#Create-Delivery)

```php
$response = TransportifyDeliveree::cancelDelivery( '<id>');
```
Sample response and format:
```php
[
    'data' => [
        'message' => 'Delivery canceled!',
        'status' => 204
    ]
]
```

### fetch Delivery List

```php
$payload = new Paginate();
$payload->setPage(1);
$payload->setPerPage(1);
$payload->setStatus(DeliveryStatus::DELIVERY_IN_PROGRESS);
$payload->setFromDate(now()->format('d-m-Y'));
$payload->setToDate(now()->format('d-m-Y'));
$payload->setSearch('Search anything');
$payload->setSortBy(\MsysCorp\TransportifyDeliveree\Lookups\Paginate::ID);
$payload->setOrderBy(\MsysCorp\TransportifyDeliveree\Lookups\Paginate::ASC);

$response = TransportifyDeliveree::fetchDeliveryList($payload);
```
Sample response and format:
```php
{
    "pagination": {
        "total_count": 500,
        "per_page": 25,
        "next_page": "https://api.deliveree.com/public_api/{version}/...",
        "previous_page": "https://api.deliveree.com/public_api/{version}/..."
    },
    "data": [
        {
          "id": 263979,
          "customer_id": 5348,
          "driver_id": 403,
          "vehicle_type_id": 1,
          "company_id": 569,
          "time_type": "now",
          "status": "delivery_in_progress",
          "note": "Fragile item that needs good care.",
          "total_fees": 400,
          "currency": "฿",
          "tracking_url": "http://localhost:3000/SqCkEVNiUbfLFey97",
          "job_order_number": "66666",
          "eta_from_driver_to_pickup": null,
          "distance_from_driver_to_pickup": null,
          "created_at": "2021-07-01T18:37:16+07:00",
          "pickup_time": null,
          "completed_at": null,
          "driver": null,
          "vehicle": {
            "vehicle_attributes": {
              "plate_number": null
            }
          },
          "locations": [
            {
              "id": 707398,
              "name": "buu dien thanh pho ho chi minh",
              "driver_note": null,
              "note": "Second floor, room 609",
              "recipient_name": "Duke",
              "position_trackings": [],
              "proof_of_delivery_photos": [],
              "signature_url": null
            },
            {
              "id": 707399,
              "name": "buu dien thanh pho ho chi minh",
              "driver_note": null,
              "note": "Second floor, room 609",
              "recipient_name": "Duke",
              "position_trackings": [],
              "proof_of_delivery_photos": [],
              "signature_url": null
            }
          ],
          "require_signatures": true,
          "booking_extra_requirements": [
            {
              "selected_amount": 1,
              "extra_requirement_id": 140,
              "name": "Extra Helper",
              "unit_price": 50000,
              "display_level_price": null,
              "display_fees": "Free",
              "display_fees_without_currency": "Free",
              "position": 1,
              "is_insurance": false
            },
            {
                "selected_amount": 1,
                "extra_requirement_id": 416,
                "name": "Goods Insurance",
                "unit_price": 0.0,
                "display_level_price": "Rp 1.000.000.000",
                "display_fees": "Free",
                "display_fees_without_currency": "Free",
                "position": 1,
                "is_insurance": true
            }
          ]
        },
    ...
    ]
}
```

### Fetch Vehicle Types

```php
$response = TransportifyDeliveree::fetchVehicleType();
```
Sample response and format:
```php
{
    "data": [
        {
            "id": 27,
            "name": "Closed Van",
            "cargo_length": 200,
            "cargo_height": 175,
            "cargo_width": 180,
            "cargo_weight": 1700,
            "cargo_cubic_meter": 7,
            "minimum_pickup_time_now": "2021-09-24T10:44:06.664+07:00",
            "minimum_pickup_time_schedule": "2021-09-24T11:44:06.664+07:00",
            "minimum_pickup_time_fullday": "2021-09-24T11:44:06.664+07:00",
            "minimum_pickup_time_fpr": "2021-09-25T09:44:06.664+07:00",
            "quick_choices": [
                {
                    "id": 318,
                    "schedule_time": 15,
                    "time_type": "now"
                },
                {
                    "id": 319,
                    "schedule_time": 30,
                    "time_type": "now"
                },
                {
                    "id": 320,
                    "schedule_time": 45,
                    "time_type": "schedule"
                }
            ]
        },
        {
            "id": 82,
            "name": "L300",
            "cargo_length": 210,
            "cargo_height": 125,
            "cargo_width": 125,
            "cargo_weight": 1000,
            "cargo_cubic_meter": 3.3,
            "minimum_pickup_time_schedule": "2021-09-24T10:44:06.684+07:00",
            "minimum_pickup_time_fullday": "2021-09-24T10:44:06.684+07:00",
            "minimum_pickup_time_fpr": "2021-09-25T09:44:06.684+07:00"
        }
    ]
}
```

### Fetch Extra Services
To Fetch Extra Services, you need: <br>
- vehicle_type_id - `vehicle_type_id` response from [Fetch Vehicle type](#Fetch-Vehicle-Types)


```php
$response = TransportifyDeliveree::fetchVehicleType('<vehicle_type_id>');
```
Sample response and format:
```php
{
  "data": [
    {
        "id": 140,
        "amount": 1,
        "unit_price": 50000,
        "name": "Extra Helper",
        "position": 1,
        "pricing_method": "normal"
    },
    {
        "id": 416,
        "amount": 0,
        "unit_price": 0.0,
        "name": "Goods Insurance",
        "position": 2,
        "pricings": [
            {
                "id": 2146,
                "fees": 0.0,
                "position": 1,
                "level_price": 1000000000.0,
                "display_level_price": "Rp 1 billion",
                "display_fees": "Free",
                "display_fees_without_currency": "Free"
            }
        ],
        "pricing_method": "by_options"
    }
  ]
}
```

### Fetch User Profile

```php
$response = TransportifyDeliveree::fetchUserProfile();
```
Sample response and format:
```php
{
    "name": "Company Name",
    "user_type": "bp_account",
    "country_code": "ID",
    "time_zone": "Bangkok",
    "currency": "Rp",
    "fleet_price_url": "https://www.deliveree.com/id/en/whole-vehicle-fleet-prices/",
    "allow_post_payment": true
}
```

## Testing
This package includes a Unit tests. You can run it by using `phpunit` command.
*
