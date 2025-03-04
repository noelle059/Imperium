<div id="about" class="about-section d-flex flex-wrap">
    <div class="about-image">
        <img src="{{ asset('images/GLOBE_BACKGROUND.svg') }}" alt="About Image">
    </div>
    <div class="about-text">
        <h1>THE FUTURE OF</h1>
        <h1><span>CLASSROOM AUTOMATION</span></h1>
        <p>Empowering educators and institutions with an intelligent, energy efficient system for seamless classroom management and security.</p>
        <button href="#" class="read-more"  data-bs-toggle="modal" data-bs-target="#insightsModal">READ MORE</button>
        
        <div class="featured">
            <h4>FEATURED IN:</h4>
            <img src="{{ asset('images/IT_ICON.svg') }}" alt="Partner 1">
            <img src="{{ asset('images/UCC_ICON.svg') }}" alt="Partner 2">
            <img src="{{ asset('images/CSD_ICON.svg') }}" alt="Partner 3">
        </div>
    </div>
</div>


<!-- Bootstrap Modal -->
<div class="modal fade" id="insightsModal" tabindex="-1" aria-labelledby="insightsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content custom-modal">
        
            <div class="modal-header">
                <img src="{{ asset('images/IMPERIUM_LOGO.svg') }}" alt="Imperium Logo" class="modal-logo">
                <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="content-box">
                    <h2 class="modal-title">An IoT-Based Energy Conservation Smart Classroom System</h2>
                    <p class="modal-subtitle"><em>Intelligent Automation & Soft Computing </em></p>
                    <p class="modal-subtitle"><em>DOI: 10.32604/iasc.2023.032250 </em></p>
                    <p class="modal-meta"><strong>Article</strong></p>


                    <p class="modal-abstract">
                        <strong>Abstract:</strong> 
                        <span id="abstract-short">
                            With the increase of energy consumption worldwide in several domains such as industry, education, and transportation,several technologies played 
                            an influential role in energy conservation such as the Internet of Things (IoT). In this article,  we describe the design and implementation of an 
                            IoT-based energy conservation smart classroom system that contributes to energy conservation in the education domain. The proposed system not only 
                            allows the user to access and control IoT devices (e.g., lights, projectors, and air conditions) in real-time, it also has the capability to aggregate 
                            the estimated energy consumption of an IoT device, the smart classroom, and the building based on the energy consumption and cost model that we propose. 
                            Moreover, the proposed model aggregates the estimated energy cost according to the Saudi Electricity Company (SEC) rates. 
                            Furthermore, the model aggregates in real-time the estimated energy conservation percentage and estimated money-saving percentage compared to data collected when the system wasn't used. 
                            The feasibility and benefits of our system have been validated on a real-world scenario which is a classroom in the college of computer science and engineering, Taibah University, Yanbu branch. 
                            The results of the experimental studies are promising in energy conservation and cost-saving when using our proposed system.
                        </span>
                    </p>

                    <p class="modal-read">
                        <strong>Read full study on</strong><br>
                        <a href="https://file.techscience.com/ueditor/files/iasc/TSP_IASC-35-3/TSP_IASC_32250/TSP_IASC_32250.pdf" 
                           target="_blank" class="modal-link">
                           https://file.techscience.com/ueditor/files/iasc/TSP_IASC-35-3/TSP_IASC_32250/TSP_IASC_32250.pdf
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>