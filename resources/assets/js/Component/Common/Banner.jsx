import React, {Component} from 'react';

class Banner extends Component{
    render() {
        return (
            <div className="slider-wrapper theme-default banner">
                <div id="slider" className="nivoSlider">
                    <img src="http://localhost/forum/public/images/banner01.jpg"
                         data-thumb="http://localhost/forum/public/images/banner01.jpg" alt=""/>
                    <img src="http://localhost/forum/public/images/banner02.jpg"
                         data-thumb="http://localhost/forum/public/images/banner02.jpg" alt=""/>
                    <img src="http://localhost/forum/public/images/banner03.jpg"
                         data-thumb="http://localhost/forum/public/images/banner03.jpg" alt=""/>
                </div>
            </div>
        );
    }
}

export default Banner;
