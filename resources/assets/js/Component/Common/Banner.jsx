import React, {Component} from 'react';
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

class Banner extends Component{
    render() {
        let settings = {
            dots: true,
            infinite: false,
            arrows: false,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1
        };

        return (
            <Slider {...settings}>
                <div>
                    <img src="http://localhost/forum/public/images/banner01.jpg" alt=""/>
                </div>
                <div>
                    <img src="http://localhost/forum/public/images/banner02.jpg" alt=""/>
                </div>
                <div>
                    <img src="http://localhost/forum/public/images/banner03.jpg" alt=""/>
                </div>
            </Slider>
        );
    }
}

export default Banner;
