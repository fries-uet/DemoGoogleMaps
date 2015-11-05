<html>
<head>
    <title>Chat bot API</title>
</head>
<body>
<div>
    <div>
        <h2>Input</h2>
        <strong>URL:</strong> tutran.net/v2/bot/chat
    </div>
    <div>
        <strong>Method:</strong> POST
    </div>
    <div>
        <strong>Parameters:</strong>
        <ul>
            <strong>key - type - example</strong>
            <li>question - string - "đường xuân thủy có tắc đường không"</li>
            <li>my_latitude - double|string - 21.036642</li>
            <li>my_longitude - double|string - 105.783978</li>
        </ul>
    </div>

    <div>
        <h2>Output:</h2>
        <h4>Hỏi tắc đường</h4>
        <pre>
{
    "status": "OK",
    "data": {
        "id": 3,
        "type": "congestion",
        "name": "Xuân Thủy",
        "city": "Hà Nội",
        "latitude": 21.0366888,
        "longitude": 105.7840455,
        "address_formatted": "Xuân Thủy, Dịch Vọng Hậu, Cầu Giấy, Hà Nội, Việt Nam",
        "time_report": 1446752124,
        "ago": 9,
        "ago_text": "1 phút"
    },
    "result": 1,
    "type": "get_traffic"
}
        </pre>


        <h4>Thông báo tắc đường hoặc thông xe</h4>
        <pre>
{
    "status": "OK",
    "data": {
        "type": "congestion",
        "name": "Xuân Thủy",
        "city": "Hà Nội",
        "latitude": 21.0366888,
        "longitude": 105.7840455,
        "address_formatted": "Xuân Thủy, Dịch Vọng Hậu, Cầu Giấy, Hà Nội, Việt Nam",
        "place_id": "ChIJzcFBnEqrNTER9WozLEV0Q1g",
        "time_report": 1446752249,
        "id": 4
    },
    "type": "post_traffic"
}
        </pre>

        <h4>Hỏi vị trí hiện tại</h4>
        <pre>
{
    "status": "OK",
    "type": "my_location",
    "name": "Xuân Thủy",
    "address_formatted": "Xuân Thủy, Dịch Vọng Hậu, Cầu Giấy, Hà Nội, Việt Nam",
    "location": {
        "lat": 21.0366888,
        "lng": 105.7840455
    },
    "place_id": "ChIJzcFBnEqrNTER9WozLEV0Q1g"
}
        </pre>

        <h4>Hỏi chỉ đường</h4>
        <pre>
{
    "status": "OK",
    "type": "coor_text",
    "info": {
        "summary": "Hồ Tùng Mậu và Phương Canh",
        "distance": "4,2 km",
        "distance_vn": "4 phẩy 2 ki lô mét",
        "duration": "12 phút"
    },
    "origin": {
        "short_name": "Xuân Thủy",
        "long_name": "Xuân Thủy, Dịch Vọng Hậu, Cầu Giấy, Hà Nội, Việt Nam",
        "geo": {
            "lat": 21.0348781,
            "lng": 105.7482309
        }
    },
    "destination": {
        "short_name": "Phương Canh",
        "long_name": "Phương Canh, Hà Nội, Việt Nam",
        "geo": {
            "lat": 21.0366888,
            "lng": 105.7840455
        }
    },
    "steps": [
        {
            "distance": "0,3 km",
            "duration": "1 phút",
            "polyline": [
                {
                    "lat": 21.03669,
                    "lng": 105.78405
                },
                {
                    "lat": 21.03669,
                    "lng": 105.784
                },
                {
                    "lat": 21.0367,
                    "lng": 105.78335
                },
                {
                    "lat": 21.03671,
                    "lng": 105.78312
                },
                {
                    "lat": 21.03672,
                    "lng": 105.78242
                },
                {
                    "lat": 21.03672,
                    "lng": 105.78203
                },
                {
                    "lat": 21.03672,
                    "lng": 105.7818
                },
                {
                    "lat": 21.03672,
                    "lng": 105.78172
                },
                {
                    "lat": 21.03673,
                    "lng": 105.78133
                },
                {
                    "lat": 21.03673,
                    "lng": 105.78113
                },
                {
                    "lat": 21.03673,
                    "lng": 105.78078
                }
            ],
            "maneuver": "start",
            "instructions": {
                "text": "Đi về hướng Tây lên Xuân Thủy",
                "info": "Băng qua Cửa Hàng Kính Thuốc Tuấn Nam (ở phía bên trái)"
            }
        },
        {
            "distance": "1,4 km",
            "duration": "4 phút",
            "polyline": [
                {
                    "lat": 21.03673,
                    "lng": 105.78078
                },
                {
                    "lat": 21.03673,
                    "lng": 105.78037
                },
                {
                    "lat": 21.0367,
                    "lng": 105.77964
                },
                {
                    "lat": 21.03669,
                    "lng": 105.77945
                },
                {
                    "lat": 21.0367,
                    "lng": 105.77924
                },
                {
                    "lat": 21.03671,
                    "lng": 105.77882
                },
                {
                    "lat": 21.03674,
                    "lng": 105.77829
                },
                {
                    "lat": 21.03679,
                    "lng": 105.77795
                },
                {
                    "lat": 21.03683,
                    "lng": 105.77773
                },
                {
                    "lat": 21.03687,
                    "lng": 105.77749
                },
                {
                    "lat": 21.03691,
                    "lng": 105.77727
                },
                {
                    "lat": 21.03695,
                    "lng": 105.77709
                },
                {
                    "lat": 21.03701,
                    "lng": 105.77686
                },
                {
                    "lat": 21.03711,
                    "lng": 105.77655
                },
                {
                    "lat": 21.0373,
                    "lng": 105.77597
                },
                {
                    "lat": 21.03764,
                    "lng": 105.77494
                },
                {
                    "lat": 21.03798,
                    "lng": 105.77375
                },
                {
                    "lat": 21.03814,
                    "lng": 105.77316
                },
                {
                    "lat": 21.03827,
                    "lng": 105.77262
                },
                {
                    "lat": 21.03837,
                    "lng": 105.77221
                },
                {
                    "lat": 21.03842,
                    "lng": 105.77203
                },
                {
                    "lat": 21.03852,
                    "lng": 105.77164
                },
                {
                    "lat": 21.03873,
                    "lng": 105.77097
                },
                {
                    "lat": 21.03918,
                    "lng": 105.76954
                },
                {
                    "lat": 21.0396,
                    "lng": 105.76808
                },
                {
                    "lat": 21.03967,
                    "lng": 105.76782
                }
            ],
            "maneuver": "straight",
            "instructions": {
                "text": "Tại Công Ty Ld Y Học Việt Hàn (Vikomed), tiếp tục vào Hồ Tùng Mậu",
                "info": "Băng qua Cửa Hàng Vật Liệu Cách Nhiệt Cát Tường (ở phía bên phải)"
            }
        },
        {
            "distance": "0,8 km",
            "duration": "2 phút",
            "polyline": [
                {
                    "lat": 21.03967,
                    "lng": 105.76782
                },
                {
                    "lat": 21.03967,
                    "lng": 105.76781
                },
                {
                    "lat": 21.03968,
                    "lng": 105.76781
                },
                {
                    "lat": 21.03969,
                    "lng": 105.7678
                },
                {
                    "lat": 21.03969,
                    "lng": 105.76779
                },
                {
                    "lat": 21.0397,
                    "lng": 105.76779
                },
                {
                    "lat": 21.0397,
                    "lng": 105.76778
                },
                {
                    "lat": 21.0397,
                    "lng": 105.76777
                },
                {
                    "lat": 21.03971,
                    "lng": 105.76777
                },
                {
                    "lat": 21.03971,
                    "lng": 105.76776
                },
                {
                    "lat": 21.03971,
                    "lng": 105.76775
                },
                {
                    "lat": 21.03971,
                    "lng": 105.76774
                },
                {
                    "lat": 21.03971,
                    "lng": 105.76773
                },
                {
                    "lat": 21.03971,
                    "lng": 105.76772
                },
                {
                    "lat": 21.03971,
                    "lng": 105.76771
                },
                {
                    "lat": 21.03971,
                    "lng": 105.7677
                },
                {
                    "lat": 21.03971,
                    "lng": 105.76769
                },
                {
                    "lat": 21.03971,
                    "lng": 105.76768
                },
                {
                    "lat": 21.0397,
                    "lng": 105.76767
                },
                {
                    "lat": 21.0397,
                    "lng": 105.76766
                },
                {
                    "lat": 21.0397,
                    "lng": 105.76765
                },
                {
                    "lat": 21.03969,
                    "lng": 105.76765
                },
                {
                    "lat": 21.03996,
                    "lng": 105.7668
                },
                {
                    "lat": 21.04058,
                    "lng": 105.76491
                },
                {
                    "lat": 21.04064,
                    "lng": 105.76473
                },
                {
                    "lat": 21.0415,
                    "lng": 105.76215
                },
                {
                    "lat": 21.04158,
                    "lng": 105.76193
                },
                {
                    "lat": 21.04191,
                    "lng": 105.76102
                }
            ],
            "maneuver": "roundabout-right",
            "instructions": {
                "text": "Tại vòng xuyến, tiếp tục đi thẳng vào Hồ Tùng Mậu/QL32",
                "info": "Đi tiếp tục theo QL32"
            }
        },
        {
            "distance": "0,6 km",
            "duration": "2 phút",
            "polyline": [
                {
                    "lat": 21.04191,
                    "lng": 105.76102
                },
                {
                    "lat": 21.04174,
                    "lng": 105.76101
                },
                {
                    "lat": 21.04145,
                    "lng": 105.76089
                },
                {
                    "lat": 21.0412,
                    "lng": 105.76077
                },
                {
                    "lat": 21.04098,
                    "lng": 105.76066
                },
                {
                    "lat": 21.04076,
                    "lng": 105.76055
                },
                {
                    "lat": 21.04057,
                    "lng": 105.76045
                },
                {
                    "lat": 21.04041,
                    "lng": 105.76036
                },
                {
                    "lat": 21.04029,
                    "lng": 105.76028
                },
                {
                    "lat": 21.0402,
                    "lng": 105.76018
                },
                {
                    "lat": 21.04005,
                    "lng": 105.75995
                },
                {
                    "lat": 21.0399,
                    "lng": 105.7597
                },
                {
                    "lat": 21.03981,
                    "lng": 105.75951
                },
                {
                    "lat": 21.0398,
                    "lng": 105.7595
                },
                {
                    "lat": 21.03957,
                    "lng": 105.75908
                },
                {
                    "lat": 21.03939,
                    "lng": 105.75885
                },
                {
                    "lat": 21.03932,
                    "lng": 105.75877
                },
                {
                    "lat": 21.03913,
                    "lng": 105.75861
                },
                {
                    "lat": 21.03884,
                    "lng": 105.75841
                },
                {
                    "lat": 21.03882,
                    "lng": 105.75839
                },
                {
                    "lat": 21.03868,
                    "lng": 105.75828
                },
                {
                    "lat": 21.03855,
                    "lng": 105.75816
                },
                {
                    "lat": 21.03838,
                    "lng": 105.75806
                },
                {
                    "lat": 21.03823,
                    "lng": 105.758
                },
                {
                    "lat": 21.03796,
                    "lng": 105.75799
                },
                {
                    "lat": 21.03742,
                    "lng": 105.75801
                },
                {
                    "lat": 21.03726,
                    "lng": 105.75803
                }
            ],
            "maneuver": "turn-left",
            "instructions": {
                "text": "Rẽ trái tại Thế giới đèn trang trí Phương Loan vào Phúc Diễn",
                "info": "Băng qua Siêu thị mẹ& bé Babimart.com Cầu Diễn - Pako.vn (ở phía bên phải)"
            }
        },
        {
            "distance": "1,1 km",
            "duration": "3 phút",
            "polyline": [
                {
                    "lat": 21.03726,
                    "lng": 105.75803
                },
                {
                    "lat": 21.03726,
                    "lng": 105.75802
                },
                {
                    "lat": 21.03707,
                    "lng": 105.75749
                },
                {
                    "lat": 21.03689,
                    "lng": 105.75682
                },
                {
                    "lat": 21.03669,
                    "lng": 105.75607
                },
                {
                    "lat": 21.0366,
                    "lng": 105.75574
                },
                {
                    "lat": 21.03657,
                    "lng": 105.75562
                },
                {
                    "lat": 21.03646,
                    "lng": 105.75521
                },
                {
                    "lat": 21.0364,
                    "lng": 105.75499
                },
                {
                    "lat": 21.03633,
                    "lng": 105.75456
                },
                {
                    "lat": 21.03622,
                    "lng": 105.75422
                },
                {
                    "lat": 21.03604,
                    "lng": 105.75379
                },
                {
                    "lat": 21.03579,
                    "lng": 105.75334
                },
                {
                    "lat": 21.03554,
                    "lng": 105.75297
                },
                {
                    "lat": 21.03544,
                    "lng": 105.75279
                },
                {
                    "lat": 21.03537,
                    "lng": 105.75262
                },
                {
                    "lat": 21.03523,
                    "lng": 105.75226
                },
                {
                    "lat": 21.03516,
                    "lng": 105.75186
                },
                {
                    "lat": 21.03513,
                    "lng": 105.75152
                },
                {
                    "lat": 21.03506,
                    "lng": 105.75117
                },
                {
                    "lat": 21.03502,
                    "lng": 105.75071
                },
                {
                    "lat": 21.035,
                    "lng": 105.75028
                },
                {
                    "lat": 21.035,
                    "lng": 105.75021
                },
                {
                    "lat": 21.035,
                    "lng": 105.7501
                },
                {
                    "lat": 21.035,
                    "lng": 105.75008
                },
                {
                    "lat": 21.03497,
                    "lng": 105.74944
                },
                {
                    "lat": 21.03496,
                    "lng": 105.74922
                },
                {
                    "lat": 21.03495,
                    "lng": 105.74896
                },
                {
                    "lat": 21.03494,
                    "lng": 105.74886
                },
                {
                    "lat": 21.03492,
                    "lng": 105.74851
                },
                {
                    "lat": 21.03488,
                    "lng": 105.74823
                }
            ],
            "maneuver": "turn-right",
            "instructions": {
                "text": "Rẽ phải tại Cửa hàng Thái Huy vào Phương Canh",
                "info": "Băng qua Flower Shop (ở phía bên trái)"
            }
        }
    ]
}
        </pre>

        <h4>Trả lời</h4>
        <pre>
{
    "status": "OK",
    "type": "speak",
    "question": "xin chào",
    "answer": "tôi là u e tê phờ rai, tôi có thể giúp gì được bạn"
}
        </pre>
    </div>
</div>
</body>
</html>