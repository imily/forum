import React, {Component} from 'react';
import Menu from './Menu';
import Banner from './Banner';
import Footer from './Footer';

class Master extends Component{
    render() {
        return (
            <div className="wrap">
                <div className="header">
                    <Menu />
                    <Banner />
                </div>
                <Footer />
            </div>
        );
    }
}

export default Master;
