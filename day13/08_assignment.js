let map;                                                                //맵을 전역변수로 따로 만들어놓고

const markers = [];                                                      

const imageSize = new kakao.maps.Size(48, 50);

const imageOption = {
    offset: new kakao.maps.Point(24, 50)
};
//==============================================================
// 기본 마커 이미지
let currentMarkerImage = new kakao.maps.MarkerImage(
    './img/marker.png',
    imageSize,
    imageOption
);
//===============================================================
// 현재 위치로 지도 생성
const mapContainer = document.getElementById('map');

navigator.geolocation.getCurrentPosition(

    // 성공
    function (position) {

        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        const currentPosition =
            new kakao.maps.LatLng(lat, lng);

        const mapOption = {
            center: currentPosition,
            level: 3
        };

        map = new kakao.maps.Map(
            mapContainer,
            mapOption
        );

        // ===========================================================
        // 내 위치 마커
        

        const myLocationImage =
            new kakao.maps.MarkerImage(
                './img/marker.png',
                imageSize,
                imageOption
            );

        const myMarker = new kakao.maps.Marker({
            position: currentPosition,
            image: myLocationImage
        });

        myMarker.setMap(map);

        // ========================================================
        // 내 위치 말풍선
        
        const infoWindow =
            new kakao.maps.InfoWindow({
                content:
                    '<div style="padding:8px;">📍 현재 내 위치</div>'
            });

        infoWindow.open(map, myMarker);

        // ========================================================
        // 지도 클릭 이벤트

        kakao.maps.event.addListener(
            map,
            'click',
            function (mouseEvent) {

                addMarker(mouseEvent.latLng);

            }
        );

    },

    // 실패
    function (error) {

        alert('위치 정보를 가져올 수 없습니다.');

        console.log(error);

    }

);


// ======================================
// 마커 추가 함수
// ======================================
function addMarker(position) {

    const marker = new kakao.maps.Marker({
        position: position,
        image: currentMarkerImage
    });

    marker.setMap(map);

    markers.push(marker);

}


// ======================================
// 마커 전체 보이기
// ======================================
function showMarkers() {

    for (let i = 0; i < markers.length; i++) {

        markers[i].setMap(map);

    }

}


// ======================================
// 마커 전체 숨기기
// ======================================
function hideMarkers() {

    for (let i = 0; i < markers.length; i++) {

        markers[i].setMap(null);

    }

}


// ======================================
// 파일 업로드
// ======================================
const fileInput =
    document.querySelector('#file');

const preview =
    document.querySelector('#preview');

fileInput.addEventListener(
    'change',
    function () {

        preview.innerHTML = '';

        const file =
            fileInput.files[0];

        if (!file) return;

        const reader =
            new FileReader();

        reader.onload = function () {

            const imgSrc =
                reader.result;

            // 다음에 생성될 마커 이미지 변경
            currentMarkerImage =
                new kakao.maps.MarkerImage(
                    imgSrc,
                    imageSize,
                    imageOption
                );

            // 미리보기
            const img =
                document.createElement('img');
            img.src = imgSrc;
            preview.appendChild(img);

        };

        reader.readAsDataURL(file);

    }
);