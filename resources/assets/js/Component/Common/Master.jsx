import React, {Component} from 'react';
import Menu from './Menu';
import Banner from './Banner';
import Footer from './Footer';
import PostMain from '../../Container/Post/PostMain';

class Master extends Component{
    render() {
        return (
            <div className="wrap">
                <div className="header">
                    <Menu />
                    <Banner />
                </div>
                <PostMain />
                <Footer />
            </div>
        );
    }
}

export default Master;
