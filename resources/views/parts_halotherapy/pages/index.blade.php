@extends('layouts.'.request()->get('layout'))
@section('content')
@include('blocks.topbanner_halotherapy')
<div class="bg-light-gray py-5 benefits-block">
    <div class="container text-center">
        <h1>HaloOne® Salt Therapy</h1>
        <div class="text">
            <p>HaloOne® Salt Therapy is the latest technology applied to millennial therapy, that goes all the way back to ancient times!</p>
            <p>HALOONE® is a complex method designed to improve the health of the respiratory system. This technology implements the wellness effect, known to people for a long time! This device reproduces a microclimate as close as possible to the air of natural salt caves.  The air saturated with salt, combined with the correct temperature regime, is able to work wonders! A mindful approach combined with the latest technology, provides a complete treatment of a wide spectrum!</p>
        </div>
        <h2 class="mb-4">The benefits of therapy.</h2>
        <div class="icons d-flex justify-content-center w-100">
            <div class="item">
                <img src="/images/parts_halotherapy/sleep_icon.svg"/><br/>
                Recovery of the breathing system
            </div>
            <div class="item">
                <img src="/images/parts_halotherapy/sleep_icon.svg"/><br/>
                Better and healthy sleep
            </div>
            <div class="item">
                <img src="/images/parts_halotherapy/sleep_icon.svg"/><br/>
                Infection control
            </div>
            <div class="item">
                <img src="/images/parts_halotherapy/sleep_icon.svg"/><br/>
                Better skin health
            </div>
            <div class="item">
                <img src="/images/parts_halotherapy/sleep_icon.svg"/><br/>
                Immunity system care
            </div>
        </div>
        <div class="text">
            It's fair to say that HALOONE® is a completely safe way to holistically heal your health! You can naturally improve sleep quality, reduce inflammation and fight germs. The creative technique of inhaling the smallest salt particles helps in treating a wide range of diseases and disorders of the body.  You will sleep well, thanks to the general recovery of the respiratory organs. You will get rid of the discomfort caused by mucus in the breathing system, whether caused by allergies or colds.
        </div>
        <div class="text-center">
            <a href="/pay" class="btn btn-primary text-uppercase px-5 py-3">Order now</a>
        </div>
    </div>
</div>
<div class="container steps-block py-4">
    <div class="row align-items-center mb-3 mb-md-0">
        <div class="col-md-6 my-3 order-2 order-md-1">
            <div class="title">The award winning salt therapy device.</div>
            <div class="description">
                Let's have a closer inspection of HALOONE® system!
            </div>
        </div>
        <div class="col-md-6 my-3 order-1 order-md-2">
            <img src="/images/{{request()->get('layout')}}/step.jpg" class="w-100"/>
        </div>
    </div>
    <div class="row align-items-center mb-3 mb-md-0">
        <div class="col-md-6 my-3">
            <img src="/images/{{request()->get('layout')}}/step2.webp" class="w-100"/>
        </div>
        <div class="col-md-6 my-3">
            <div class="title">How does the HALOONE® system work?</div>
            <div class="description">
                This device disperses tiny particles of saline solutions, tested in the labs, into the air. These micro particles are then inhaled through the airways and start producing its beneficial effects.  They circulate in the respiratory tract, helping to clear them of blockages and mucus, and fight inflammation. Also the antibacterial effects of salt help control various infections.
            </div>
        </div>
    </div>
    <div class="row align-items-center mb-3 mb-md-0">
        <div class="col-md-6 my-3 order-2 order-md-1">
            <div class="title">Refill the salt pods</div>
            <div class="description">
                The HALOONE® salt pods contain a purified 3% saline solution that meets strict medical safety standards. HALOONE® uses micro particles of salt in solution rather than dry crushed salt, a genuine choice.  The basic set includes 30 salt pods. These cartridges are easily replaceable and can be purchased on our website.
            </div>
        </div>
        <div class="col-md-6 my-3 order-1 order-md-2">
            <img src="/images/{{request()->get('layout')}}/step3.webp" class="w-100"/>
        </div>
    </div>
    <div class="row align-items-center mb-3 mb-md-0">
        <div class="col-md-6 my-3">
            <img src="/images/{{request()->get('layout')}}/step4.webp" class="w-100"/>
        </div>
        <div class="col-md-6 my-3">
            <div class="title">Make your sauna experience healthy!</div>
            <div class="description">
                HALOONE® is a breakthrough in health technology!  The world's first portable halotherapy device, compact and battery-powered. Lightweight, cordless and you can take it anywhere you want. Using the HALOONE® device in the sauna, you will experience an additional revitalizing effect!  The device works silently, ensuring you complete relaxation and recovery.
            </div>
        </div>
    </div>    
    <div class="text-center my-3">
        <a href="/pay" class="btn btn-primary text-uppercase px-5 py-3">Order now</a>
    </div>
</div>
<div class="bg-light-gray py-5">
    <div class="container">
        <h2 class="title text-center mb-4">Health benefits of salt therapy include aid in treatment of the following conditions:</h2> 
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td>Asthma</td>
                        <td>Colds</td>
                        <td>Depression</td>
                    </tr>
                    <tr>
                        <td>Chronic Bronchitis</td>
                        <td>Ear Infections</td>
                        <td>Seasonal Affective Disorder&nbsp; (SAD)</td>
                    </tr>
                    <tr>
                        <td>Breathlessness</td>
                        <td>Sinus Infections</td>
                        <td>Psoriasis</td>
                    </tr>
                    <tr>
                        <td>Chest Tightness</td>
                        <td>Allergies</td>
                        <td>Eczema</td>
                    </tr>
                    <tr>
                        <td>Tonsillitis</td>
                        <td>Hay Fever</td>
                        <td>Acne</td>
                    </tr>
                    <tr>
                        <td>Laryngitis</td>
                        <td>Snoring</td>
                        <td>Rosacea</td>
                    </tr>
                    <tr>
                        <td>COPD</td>
                        <td>Sleep Apnea</td>
                        <td>Dry Skin</td>
                    </tr>
                    <tr>
                        <td>Cystic Fibrosis</td>
                        <td>Insomnia</td>
                        <td>Rashes</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="gallery-block py-5">
    <div class="container">
        <h2 class="title text-center mb-4 text-uppercase">Gallery</h2>
        <div class="items owl-carousel">
            <a href="/images/{{request()->get('layout')}}/gallery.jpg" data-fancybox="gallery">
                <img src="/images/{{request()->get('layout')}}/gallery.jpg"/>
            </a>
            <a href="/images/{{request()->get('layout')}}/gallery.jpg" data-fancybox="gallery">
                <img src="/images/{{request()->get('layout')}}/gallery.jpg"/>
            </a>
            <a href="/images/{{request()->get('layout')}}/gallery.jpg" data-fancybox="gallery">
                <img src="/images/{{request()->get('layout')}}/gallery.jpg"/>
            </a>
            <a href="/images/{{request()->get('layout')}}/gallery.jpg" data-fancybox="gallery">
                <img src="/images/{{request()->get('layout')}}/gallery.jpg"/>
            </a>
            <a href="/images/{{request()->get('layout')}}/gallery.jpg" data-fancybox="gallery">
                <img src="/images/{{request()->get('layout')}}/gallery.jpg"/>
            </a>
            <a href="/images/{{request()->get('layout')}}/gallery.jpg" data-fancybox="gallery">
                <img src="/images/{{request()->get('layout')}}/gallery.jpg"/>
            </a>
            <a href="/images/{{request()->get('layout')}}/gallery.jpg" data-fancybox="gallery">
                <img src="/images/{{request()->get('layout')}}/gallery.jpg"/>
            </a>
        </div>
    </div>
</div>
<div class="bg-light-gray py-5 faq-block">
    <div class="container">
        <h2 class="title text-center mb-4 text-uppercase">Frequently asked questions about halotherapy</h2>
        <div class="col-md-10 offset-md-1">
            <div class="items">
                <div class="item">
                    <div class="question">Why does the HALOONE® technology use saline solution instead of dry salt?</div>
                    <div class="answer"><p>It's easy: the fact is that a moist salt solution is much easier to spread around the room, so it can be inhaled evenly. Also, moistened salt particles are much longer able to stay in the air, so you can get more salt fractions during your therapy session.</p></div>
                </div>
                <div class="item">
                    <div class="question">What is the duration of halotherapy? And for how long does the session last?</div>
                    <div class="answer">
                        <p>Normally, the duration of the procedure for adults lasts 40-60 minutes, and for kids - no more than half an hour. Experts believe that one session in the salt room can replace three days at the sea.</p>
                        <p>The therapeutic course of halotherapy includes 15-25 daily sessions. For prophylactic purposes the procedures are appointed twice every 7-10 days. If necessary, the treatment can be repeated after a half-year.</p>
                    </div>
                </div>
                
                <div class="item">
                    <div class="question">How much salt is in the saline solution?</div>
                    <div class="answer"><p>The solution used in our technology is a 3% salt solution of true pharmaceutical quality. It is 99.99% pure. No fillers or additives are added. Also, it is important to know that we use salt obtained exclusively from nature, and is purified to the highest level. So we use salt that is used in hospitals and laboratories for research.</p></div>
                </div>
                <div class="item">
                    <div class="question">How long will one salt cartridge last?</div>
                    <div class="answer"><p>One cartridge will last about half an hour. After that, you can change the cartridge to continue the procedure. But after the cartridge is finished, the air in your sauna will be saturated with saline solution for a long time to come.</p></div>
                </div>
                <div class="item">
                    <div class="question">What temperature should be in the sauna for proper use of HALOONE®?</div>
                    <div class="answer"><p>That's an important question, 'cause the HALOONE® system should be used at a temperature no higher than 140°F (60°C). The duration of the session should not exceed one hour. The point is that the HALOONE® device should not be used in the sauna all the time. If you use your sauna for several sessions in a row, you must take it out after each use as well.</p></div>
                </div>
                <div class="item">
                    <div class="question">Can I use salt from another manufacturer, or make it myself?</div>
                    <div class="answer"><p>No, we strongly advise against this, because using third-party salt or making a saline solution at home is quite dangerous! It can harm your body if the salt is contaminated and you inhale it. Also, an untested solution can ruin the sensitive membranes in your device. In our salt capsules, we use only safe and tested solutions used in hospitals and laboratories.</p></div>
                </div>
                <div class="item">
                    <div class="question">Can you compare halotherapy procedures to a vacation or life on the coast? For example by the seaside, where there is a lot of salt in the air? </div>
                    <div class="answer"><p>The fact is that HALOONE® technology is more effective because the device has a set of different filters and membranes. This ensures that salt particles are produced in different sizes, useful for therapy. It is also important to know that our salt pods created with HALOONE® technology provide a higher concentration of salt than the very sea air you inhale at the coast.</p></div>
                </div>
                <div class="item">
                    <div class="question">Still, what are the health benefits of halotherapy?</div>
                    <div class="answer"><p>We can definitely say that therapy has a very long list of benefits! Halotherapy can help with healthy sleep, breathing problems, immunity in general, as well as helping to fight infections. There are series of studies, showing that these sessions reduce inflammation, as it has antibacterial and anti-inflammatory effects and can help with digestive problems, depression, skin conditions.  The list of diseases the symptoms of which are fully or partially gone, as well as the observed cure process is great. Here are just a few: asthma, tonsillitis, chronic bronchitis, laryngitis, shortness of breath, colds, ear infections and even snoring. HALOONE® technology can also relieve problems such as depression, insomnia, psoriasis, allergies, eczema, hay fever, acne, dry skin and rashes.</p></div>
                </div>
                <div class="item">
                    <div class="question">Who is recommended halotherapy for prophylactic purposes?</div>
                    <div class="answer"><p>For prevention purposes, this therapy is recommended for people who have had the flu, acute respiratory viral infections, pneumonia.  Halotherapy is effective for children who are common exposed to colds, as evidenced by the reviews of many parents. Quite useful halotherapy for coughs, associated with smoking.</p></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection