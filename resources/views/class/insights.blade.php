<div id="insights" class="insights">
    <img class="img-fluid" src="{{ asset('images/INSIGHT_BG.svg') }}" alt="INSIGHTS_BG.svg" />
    <button class="more-info-btn" data-bs-toggle="modal" data-bs-target="#insightsModal">More Information</button>
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
                    <h2 class="modal-title">IoT Based Energy Efficient Smart Classroom</h2>
                    <p class="modal-subtitle"><em>Journal of Multidisciplinary Engineering Science Studies (MESS)</em></p>
                    <p class="modal-meta"><strong>ISSN: 2458-925X | Vol. 6 Issue 12 | December 2020</strong></p>

                    <p class="modal-abstract">
                        <strong>Abstract:</strong> 
                        <span id="abstract-short">
                            This paper presents a cost-effective energy-efficient Internet of Things (IoT) based device controlling system that can be 
                            used with minimum user interaction, in the case of operating any electrical device...
                        </span>
                        <span id="abstract-full" style="display: none;">
                            The proposed prototype of “IoT Based Energy Efficient Smart Classroom” is implemented to reduce the wastage of electricity 
                            in a lecture hall in the Sabaragamuwa University of Sri Lanka. The system controls the operations of electrical devices (such as ON/OFF) by identifying the presence of human in a specific area. 
                            In the system, a Microsoft Kinect sensor is used to track the presence of humans and the system can be responded to environmental conditions such as temperature, humidity, and light intensity at the human-occupied area. 
                            A DHT22 sensor and LDR are connected with the Arduino ATMega board to measure those environmental conditions.
                            These sensors provide real-time data on environmental conditions in the lecture hall and a web application that is included in this system is updated using these data. NodeMCU IoT device is used to send all data to the host machine through the internet.
                            Finally, the system was tested in 80 incidences using four students in a laboratory and the test results show 97.62% accuracy for the implemented prototype.
                        </span>
                    </p>

                    <button id="seeMoreBtn" class="see-more-btn">See More</button>

                    <p class="modal-read">
                        <strong>Read full study on</strong><br>
                        <a href="https://www.jmess.org/wp-content/uploads/2020/12/JMESSP13420670.pdf" 
                           target="_blank" class="modal-link">
                            https://www.jmess.org/wp-content/uploads/2020/12/JMESSP13420670.pdf
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("seeMoreBtn").addEventListener("click", function() {
        let shortText = document.getElementById("abstract-short");
        let fullText = document.getElementById("abstract-full");
        let btn = document.getElementById("seeMoreBtn");

        if (fullText.style.display === "none") {
            shortText.style.display = "none";
            fullText.style.display = "inline";
            btn.innerText = "See Less";
        } else {
            shortText.style.display = "inline";
            fullText.style.display = "none";
            btn.innerText = "See More";
        }
    });
</script>
