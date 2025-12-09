    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeInOut 0.5s ease-in-out;
        }

        .modal-content {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 20%;
            transform: translate(-50%, -50%);
            background-color: #fefefe;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            /* animation: fadeIn 0.5s ease-in-out 0.2s; */
        }

        .acs-td-button {
            display: flex;
            gap: 5px
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            text-align: right;
        }

        .close:hover {
            color: black;
        }

        .clickable-row {
            cursor: pointer;
        }

        #table_Computer tbody tr.clickable-row:hover {
            background-color: #f5f5f5 !important;
        }

        #modalComputerContent {
            align-self: center
        }

        /* @keyframes fadeInOut {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        } */

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }
    </style>

    <!-- The Modal -->
    <div id="modalComputer" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalComputer')">&times;</span>
            <div id="modalComputerContent">
            </div>
        </div>
    </div>

    <div id="modalAddProcessor" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalAddProcessor')">&times;</span>
            <div id="modalComputerContent">
            </div>
        </div>
    </div>

    <div id="modalAddMemory" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalAddMemory')">&times;</span>
            <div id="modalComputerContent">
            </div>
        </div>
    </div>

    <div id="modalAddHarddisk" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalAddHarddisk')">&times;</span>
            <div id="modalComputerContent">
            </div>
        </div>
    </div>

    <div id="modalAddOperatingSystem" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalAddOperatingSystem')">&times;</span>
            <div id="modalComputerContent">
            </div>
        </div>
    </div>

    <div id="modalAddGraphicCard" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalAddGraphicCard')">&times;</span>
            <div id="modalComputerContent">
            </div>
        </div>
    </div>

    <div id="modalAddMonitor" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalAddMonitor')">&times;</span>
            <div id="modalComputerContent">
            </div>
        </div>
    </div>

    <script>
        function openModal(value) {
            var modalId = 'modal' + value.split(' ')[1];
            var modal = document.getElementById(modalId);
            $(modal).ready(function() {
                $(modal).fadeIn(500);
            })
            event.stopPropagation();
        }

        function closeModal(value) {
            var modal = document.getElementById(value);
            modal.style.animation = 'fadeOut 0.5s ease-in-out';
            modal.addEventListener('animationend', function animationEndHandler() {
                if (modal.style.display !== 'none') {
                    modal.style.display = 'none';
                    modal.style.animation = 'none';
                    modal.removeEventListener('animationend', animationEndHandler);
                }
            });
        }

        function closeAllModals() {
            // Close all modals and overlay
            console.log(modal);
            closeModal('modalComputer');
            closeModal('modalAddProcessor');
            closeModal('modalAddMemory');
            closeModal('modalAddHarddisk');
            closeModal('modalAddOperatingSystem');
            closeModal('modalAddGraphicCard');
            closeModal('modalAddMonitor');
        }

        // Close the modal if the user clicks outside the modal content
        // window.onclick = function(event) {
        //     var modals = document.getElementsByClassName('modal');
        //     // Convert HTMLCollection to an array for easier manipulation
        //     var modalsArray = Array.from(modals);
        //     console.log(modalsArray);
        //     // Check if the click is outside any of the modals
        //     if (!modalsArray.some(modal => modal.contains(event.target)) && !event.target.classList.contains('modal')) {
        //         closeAllModals();
        //     }
        // }
    </script>
