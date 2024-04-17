<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://https://brainstudioz.com/
 * @since      1.0.0
 *
 * @package    Find_Doctor
 * @subpackage Find_Doctor/public/partials
 */
function doctor_search_shortcode() {
    ob_start();
    ?>
    
    <div class="doctor-search-container">
        <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <div class="row">
                <div class="col-4">
                    <div class="doctor-search-box">
                      
                        <input type="text" id="searchInput" oninput="getSuggestions(this.value)" class="form-control" placeholder="Type your Search">
                        <div class="suggestion-dropdown" id="suggestion-dropdown">
                            <div class="suggestion-area" id="suggestion-area-doctors">
                                <h2>By Doctor Name <a href="http://"><b>View all</b></a> </h2>
                                
                            </div>
                           <!--  <div class="suggestion-area" id="suggestion-area-department">
                                <h2>By Department <a href="http://"><b>View all</b></a> </h2>
                                
                            </div> -->
                            <div class="suggestion-area" id="suggestion-area-symptom">
                                <h2>By Symptom <a href="http://"><b>View all</b></a> </h2>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 text-center">
                    <button type="button" class="btn btn-tab" id="tab-doc" onclick="getData('get_doctors', this)">By Doctor Name</button>
                </div>
                <div class="col-2 text-center">
                    <button type="button" class="btn btn-tab" id="tab-dep" onclick="getData('get_departments', this)">By Department</button>
                </div>
                <div class="col-2 text-center">
                    <button type="button" class="btn btn-tab" id="tab-sym" onclick="getData('get_symptoms', this)">By Symptom</button>
                </div>
                <div class="col-2 text-right">
                    <a href="#" id="FindDoctorFilter" class="btn btn-filter disabled"><i class="fas fa-filter"></i> More Filters <span class="badge text-bg-secondary">4</span></a>
                </div>
            </div>
            <div id="filter-tab" class="filter-tab">
                <hr>
                <div class="row align-items-start">
                    <div class="col-md-3">
                        <label>Sort By</label>
                        <select id="sort-doc-names" onchange="sortDocFilter(this)">
                            <option value="">Select option</option>
                            <option value="asc_first_name">First name (A - Z)</option>
                            <option value="dsc_first_name">First name (Z - A)</option>
                            <option value="asc_last_name">Last name (A - Z)</option>
                            <option value="dsc_last_name">Last name (Z - A)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Gender</label>
                        <select onchange="genderBasedFilter(this)">
                            <option value="all" selected>All</option>
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Languages Spoken</label>
                        <select id="ddlLanguage" onchange="languageBasedFilter(this)">
                            <option value="all" selected>All</option>
                            <option value="arabic">Arabic</option>
                            <option value="english">English</option>
                            <option value="french">French</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="SortingArea" id="doc-alphabets"  style="display: none;">
    </div>
    <div id="doc-names-alphabetically" style="display: none;">
    </div>
	<script>
        let charectors = [
            {
                "letter": "A",
                "status": "inactive",
            },
            {
                "letter": "B",
                "status": "inactive",
            },
            {
                "letter": "C",
                "status": "inactive",
            },
            {
                "letter": "D",
                "status": "inactive",
            },
            {
                "letter": "E",
                "status": "inactive",
            },
            {
                "letter": "F",
                "status": "inactive",
            },

            {
                "letter": "G",
                "status": "inactive",
            },
            {
                "letter": "H",
                "status": "inactive",
            },
            {
                "letter": "I",
                "status": "inactive",
            },
            {
                "letter": "J",
                "status": "inactive",
            },
            {
                "letter": "K",
                "status": "inactive",
            },
            {
                "letter": "L",
                "status": "inactive",
            },
            {
                "letter": "M",
                "status": "inactive",
            },
            {
                "letter": "N",
                "status": "inactive",
            },
            {
                "letter": "O",
                "status": "inactive",
            },
            {
                "letter": "P",
                "status": "inactive",
            },
            {
                "letter": "Q",
                "status": "inactive",
            },
            {
                "letter": "R",
                "status": "inactive",
            },
            {
                "letter": "S",
                "status": "inactive",
            },
            {
                "letter": "T",
                "status": "inactive",
            },
            {
                "letter": "U",
                "status": "inactive",
            },
            {
                "letter": "V",
                "status": "inactive",
            },
            {
                "letter": "W",
                "status": "inactive",
            },
            {
                "letter": "X",
                "status": "inactive",
            },
            {
                "letter": "Y",
                "status": "inactive",
            },
            {
                "letter": "Z",
                "status": "inactive",
            },
        ];
        function getSuggestions(input) {
            const doctors = document.getElementById('suggestion-area-doctors');
            // const departments = document.getElementById('suggestion-area-department');
            const symptoms = document.getElementById('suggestion-area-symptom');
            const suggestionsContainer = document.getElementById('suggestion-dropdown');
            // suggestionsContainer.innerHTML = '';
            // doctors.children['doctor-list'].innerHTML = '';
            doctors.innerHTML = '';
            const h2 = document.createElement('h2');
            h2.textContent = 'By Doctor Name';
            const a = document.createElement('a');
            a.href = "#";
            const b = document.createElement('b');
            b.textContent = 'View all';
            a.appendChild(b);
            h2.appendChild(a);
            doctors.appendChild(h2);
            
            // departments.innerHTML = '';
            // const dh2 = document.createElement('h2');
            // dh2.textContent = 'By Department';
            // const da = document.createElement('a');
            // da.href = "#";
            // const db = document.createElement('b');
            // db.textContent = 'View all';
            // da.appendChild(db);
            // dh2.appendChild(da);
            // departments.appendChild(dh2);

            symptoms.innerHTML = '';
            const sh2 = document.createElement('h2');
            sh2.textContent = 'By Symptom';
            const sa = document.createElement('a');
            sa.href = "#";
            const sb = document.createElement('b');
            sb.textContent = 'View all';
            sa.appendChild(sb);
            sh2.appendChild(sa);
            symptoms.appendChild(sh2);

            if (input.trim() === '') {
                suggestionsContainer.style.display = 'none';
                return;
            }
            if (input.trim() != '') {
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const suggestions = JSON.parse(xhr.responseText);
                        displaySuggestions(suggestions);
                    } else {
                        console.error('Failed to fetch suggestions.');
                    }
                }
                };

                const url = `/wp-json/fine_doc/api/search?q=${encodeURIComponent(input)}`;
                xhr.open('GET', url, true);
                xhr.send();
            }
        }

        function displaySuggestions(suggestions) {
            const suggestionsContainer = document.getElementById('suggestion-dropdown');
            const suggestionsForDoctors = document.getElementById('suggestion-area-doctors');
            // populate doctors
            if (suggestions.doctors.length > 0) {
                const ul = document.createElement('ul');
                ul.id = 'doctor-list';
                const doctors = suggestions.doctors;
                doctors.forEach(doctor => {
                    const a = document.createElement('a');
                    a.title = doctor.post_title;
                    a.textContent = doctor.post_title;
                    a.href = "/doctors/"+doctor.post_name;
                    const li = document.createElement('li');
                    // li.textContent = doctor.post_title;
                    li.onclick = () => {
                        document.getElementById('searchInput').value = doctor.post_title;
                        suggestionsContainer.style.display = 'none';
                    };
                    li.appendChild(a);
                    ul.appendChild(li);
                });
                suggestionsForDoctors.appendChild(ul);
                suggestionsContainer.style.display = 'block';
            } else {
                suggestionsContainer.style.display = 'none';
            }
            // populate departments
            // const suggestionsForDepartment = document.getElementById('suggestion-area-department');
            // if (suggestions.dempartments.length > 0) {
            //     const ul = document.createElement('ul');
            //     const dempartments = suggestions.dempartments;
            //     console.log(dempartments)
            //     dempartments.forEach(dempartment => {
            //         const li = document.createElement('li');
            //         li.textContent = dempartment.name;
            //         li.onclick = () => {
            //             document.getElementById('searchInput').value = dempartment.name;
            //             suggestionsContainer.style.display = 'none';
            //         };
            //         ul.appendChild(li);
            //     });
            //     suggestionsForDepartment.appendChild(ul);
            //     suggestionsContainer.style.display = 'block';
            // } else {
            //     suggestionsContainer.style.display = 'none';
            // }

             // populate symptopms
            const suggestionsForsymptom = document.getElementById('suggestion-area-symptom');
            if (suggestions.doctors.length > 0) {
                const ul = document.createElement('ul');
                const symptoms = suggestions.symptoms;
                symptoms.forEach(symptom => {
                    const a = document.createElement('a');
                    a.title = symptom.name;
                    a.textContent = symptom.name;
                    a.href = "/symptom/"+symptom.slug;
                    const li = document.createElement('li');
                    // li.textContent = symptom.name;
                    li.onclick = () => {
                        document.getElementById('searchInput').value = symptom.name;
                        suggestionsContainer.style.display = 'none';
                    };
                    li.appendChild(a);
                    ul.appendChild(li);
                });
                suggestionsForsymptom.appendChild(ul);
                suggestionsContainer.style.display = 'block';
            } else {
                suggestionsContainer.style.display = 'none';
            }
        }

        document.addEventListener('click', function(event) {
            // console.log('event listener')
            const suggestionsContainer = document.getElementById('suggestion-dropdown');
            const searchInput = document.getElementById('searchInput');

            if (!suggestionsContainer.contains(event.target) && event.target !== searchInput) {
                // console.log('event listener if')
                suggestionsContainer.style.display = 'none';
            }
        });

        function activeAndDisabledButtons(element) {
            if (element.id == 'tab-doc') {
                element.classList.add('active');
                document.getElementById('tab-sym').classList.remove('active');
                document.getElementById('tab-dep').classList.remove('active');
                document.getElementById("FindDoctorFilter").classList.remove('disabled');
            }else if (element.id == 'tab-dep') {
                element.classList.add('active');
                document.getElementById('tab-doc').classList.remove('active');
                document.getElementById('tab-sym').classList.remove('active');
                document.getElementById("filter-tab").style.display = 'block';
                document.getElementById("FindDoctorFilter").classList.add('disabled');
            }else if (element.id == 'tab-sym') {
                element.classList.add('active');
                document.getElementById('tab-doc').classList.remove('active');
                document.getElementById('tab-dep').classList.remove('active');
                document.getElementById("filter-tab").style.display = 'block';
                document.getElementById("FindDoctorFilter").classList.add('disabled');
            }
            // console.log(element.id)
        }

        let globDoctors;
        function getData($endPoint, element){
            const docNamesContainer = document.getElementById('doc-names-alphabetically');
            const docAlphaContainer = document.getElementById('doc-alphabets');
            docAlphaContainer.innerHTML = '';
            docNamesContainer.innerHTML = '';
            activeAndDisabledButtons(element);
            // console.log($endPoint)
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if ($endPoint != 'get_doctors'){
                        displayData(response, $endPoint);
                    }else{
                        globDoctors = response;
                        displayDoctors(response);
                    }
                } else {
                    console.error('Failed to fetch suggestions.');
                }
            }
            };

            const url = `/wp-json/fine_doc/api/`+$endPoint;
            xhr.open('GET', url, true);
            xhr.send();
        }

        // function searchDocOjectOnSingleCharector(){

        // }
        
        function displayDoctors(doctors) {
            // console.log(doctors)
            const tempCharectors = charectors;
            tempCharectors.forEach( charector => {
                for (let doctor of doctors) {
                    let cap = doctor.post_title.search(charector.letter);
                        // console.log(doctor.post_title +" : " +charector.letter +" : " + cap);
                    let low = doctor.post_title.search(charector.letter.toLowerCase());
                    if (cap != -1 || low != -1) {
                        charector.status = 'active';
                        break;
                    }
                }
            });
            convertName(doctors);
            const docNamesContainer = document.getElementById('doc-names-alphabetically');
            const docAlphaContainer = document.getElementById('doc-alphabets');
            docAlphaContainer.innerHTML = '';

            let alpha_filter_ul = processAlphbeteFilter(tempCharectors, doctors);
            docAlphaContainer.appendChild(alpha_filter_ul);

            if (doctors.length > 0) {
                const ul = document.createElement('ul');
                ul.classList.add('searched-items');
                // const doctors = suggestions.doctors;
                // console.log(doctors)
                doctors.forEach(doctor => {
                    const a = document.createElement('a');
                    a.title = doctor.post_title;
                    a.textContent = doctor.post_title;
                    a.href = "/doctors/"+doctor.post_name;
                    const li = document.createElement('li');
                    // li.textContent = doctor.post_title;
                    li.onclick = () => {
                        document.getElementById('searchInput').value = doctor.post_title;
                        suggestionsContainer.style.display = 'none';
                    };
                    li.appendChild(a);
                    ul.appendChild(li);
                });
                docNamesContainer.appendChild(ul);
                docNamesContainer.style.display = 'block';
                docAlphaContainer.style.display = 'block';
            } else {
                docNamesContainer.style.display = 'none';
                docAlphaContainer.style.display = 'none';
            }

        }
        // Display alphabets accordingt to search results
        function processAlphbeteFilter(charectors, doctors) {
            const ul = document.createElement('ul');
            ul.classList.add('sorting-li');
            ul.classList.add('sorting-charector');
            // const doctors = suggestions.doctors;
            charectors.forEach(charector => {
            // console.log(charector)
                const a = document.createElement('a');
                if (charector.status == 'inactive') {
                    a.classList.add('disabled');
                }
                // a.title = doctor.post_title;
                a.textContent = charector.letter;
                a.href = "javascript:void(0);";
                const li = document.createElement('li');
                // li.textContent = doctor.post_title;
                li.onclick = (e) => {
                    processDoctorFilter(doctors, charector);
                };
                li.appendChild(a);
                ul.appendChild(li);
            });
            return ul;
        }
        // Display doctors according to click of alphabetes filter
        function processDoctorFilter(doctors, charector){
            const docNamesContainer = document.getElementById('doc-names-alphabetically');
            if (charector.status == 'active') {
                docNamesContainer.innerHTML = '';
                const ul = document.createElement('ul');
                ul.class = 'sorting-li';
                for (let doctor of doctors) {
                    let cap = doctor.post_title.search(charector.letter);
                    let low = doctor.post_title.search(charector.letter.toLowerCase());
                    if (cap != -1 || low != -1) {
                        const a = document.createElement('a');
                        a.title = doctor.post_title;
                        a.textContent = doctor.post_title;
                        a.href = "/doctors/"+doctor.post_name;
                        const li = document.createElement('li');
                        // li.onclick = () => {
                        //     document.getElementById('searchInput').value = doctor.post_title;
                        //     suggestionsContainer.style.display = 'none';
                        // };
                        li.appendChild(a);
                        ul.appendChild(li);
                    }
                }
                docNamesContainer.appendChild(ul);
            }
        }

        // Display department and symptoms according to click of alphabetes filter
        function processTaxonomyFilter(listOfTaxonomies, charector){
            const docNamesContainer = document.getElementById('doc-names-alphabetically');
            if (charector.status == 'active') {
                docNamesContainer.innerHTML = '';
                const ul = document.createElement('ul');
                ul.class = 'sorting-li';
                for (let taxonomy of listOfTaxonomies) {
                    let cap = taxonomy.name.search(charector.letter);
                    let low = taxonomy.name.search(charector.letter.toLowerCase());
                    if (cap != -1 || low != -1) {
                        const a = document.createElement('a');
                        a.title = taxonomy.name;
                        a.textContent = taxonomy.name;
                        a.href = "/doctors/"+taxonomy.slug;
                        const li = document.createElement('li');
                        // li.onclick = () => {
                        //     document.getElementById('searchInput').value = doctor.post_title;
                        //     suggestionsContainer.style.display = 'none';
                        // };
                        li.appendChild(a);
                        ul.appendChild(li);
                    }
                }
                docNamesContainer.appendChild(ul);
            }
        }

        // Display Department and Sysptoms
        function displayData(listOfTaxonomies, $endPoint) {
            // Enable or disable alphabets filter
            const tempCharectors = charectors;
            tempCharectors.forEach( charector => {
                for (let taxonomy of listOfTaxonomies) {
                    let cap = taxonomy.name.search(charector.letter);
                        // console.log(taxonomy.name +" : " +charector.letter +" : " + cap);
                    let low = taxonomy.name.search(charector.letter.toLowerCase());
                    if (cap != -1 || low != -1) {
                        charector.status = 'active';
                        break;
                    }
                }
            });
            // console.log(tempCharectors)
            const docNamesContainer = document.getElementById('doc-names-alphabetically');
            const docAlphaContainer = document.getElementById('doc-alphabets');
            docAlphaContainer.innerHTML = '';

            let alpha_filter_ul = processAlphbeteFilterForTaxonomy(tempCharectors, listOfTaxonomies);
            docAlphaContainer.appendChild(alpha_filter_ul);

            if (listOfTaxonomies.length > 0) {
                const ul = document.createElement('ul');
                ul.classList.add('searched-items');
                // const listOfTaxonomies = suggestions.listOfTaxonomies;
                listOfTaxonomies.forEach(taxonomy => {
                    const a = document.createElement('a');
                    // a.title = taxonomy.post_title;
                    a.textContent = taxonomy.name;
                    if ($endPoint == 'get_symptoms') {
                        a.href = "/symptom/"+taxonomy.slug;
                    }else{
                        a.href = "/doctors_category/"+taxonomy.slug;
                    }
                    const li = document.createElement('li');
                    // li.textContent = doctor.post_title;
                    li.onclick = () => {
                        document.getElementById('searchInput').value = taxonomy.name;
                        suggestionsContainer.style.display = 'none';
                    };
                    li.appendChild(a);
                    ul.appendChild(li);
                });
                docNamesContainer.appendChild(ul);
                docNamesContainer.style.display = 'block';
                docAlphaContainer.style.display = 'block';
            } else {
                docNamesContainer.style.display = 'none';
                docAlphaContainer.style.display = 'none';
            }

        }

         // Display alphabets accordingt to search results
        function processAlphbeteFilterForTaxonomy(charectors, listOfTaxonomies) {
            const ul = document.createElement('ul');
            ul.classList.add('sorting-li');
            ul.classList.add('sorting-charector');
            // const listOfTaxonomies = suggestions.listOfTaxonomies;
            charectors.forEach(charector => {
                const a = document.createElement('a');
                if (charector.status == 'inactive') {
                    a.classList.add('disabled');
                }
                // a.title = doctor.post_title;
                a.textContent = charector.letter;
                a.href = "javascript:void(0);";
                const li = document.createElement('li');
                // li.textContent = doctor.post_title;
                li.onclick = (e) => {
                    processTaxonomyFilter(listOfTaxonomies, charector);
                };
                li.appendChild(a);
                ul.appendChild(li);
            });
            return ul;
        }
        // CREATE A NEW ARRAY OF OBJECTS WITH FIRST AND LAST NAME
        function convertName(doctors){
            let temp = [];
            for (let doctor of doctors) {
                const doc = doctor.post_title.split(' ')
                const obj = {
                    first_name:doc[1], 
                    last_name:doc[2], 
                    post_name: doctor.post_name, 
                    gender: doctor.gender, 
                    languages: doctor.languages, 
                    post_title: doctor.post_title};
                // console.log(obj)
                temp.push(obj);
            }
            globDoctors = temp;
        }

        function genderBasedFilter(gender){
            if (gender.value == 'all') {
                displaySortedAscDscDoctors(globDoctors);
            }else{
                let tempArr = [];
                for (var doctor of globDoctors) {
                    if (doctor.gender.length > 0 && doctor.gender[0].toLowerCase() == gender.value  ) {
                        tempArr.push(doctor);
                    }
                }
                displaySortedAscDscDoctors(tempArr);
            }
        }

        function languageBasedFilter(language) {
            if (language.value == 'all') {
                displaySortedAscDscDoctors(globDoctors);
            }else{
                let tempArr = [];
                for (var doctor of globDoctors) {
                    if (doctor.languages.length > 0  ) {
                        for(let lang of doctor.languages){
                            if (lang.toLowerCase() == language.value) {
                                tempArr.push(doctor);
                                break;
                            }
                        }
                    }
                }
                displaySortedAscDscDoctors(tempArr);
            }
        }

        function sortDocFilter(select){
            var filter = select.value;
            if (filter == 'asc_first_name') {
                globDoctors.sort((a, b) => {
                    let fa = a.first_name.toLowerCase(),
                        fb = b.first_name.toLowerCase();
                    if (fa < fb) {
                        return -1;
                    }
                    if (fa > fb) {
                        return 1;
                    }
                    return 0;
                });
            }else if (filter == 'asc_last_name') {
                globDoctors.sort((a, b) => {
                    let fa = a.last_name.toLowerCase(),
                        fb = b.last_name.toLowerCase();
                    if (fa < fb) {
                        return -1;
                    }
                    if (fa > fb) {
                        return 1;
                    }
                    return 0;
                });
            }else if (filter == 'dsc_first_name') {
                globDoctors.sort((a, b) => {
                    let fa = a.first_name.toLowerCase(),
                        fb = b.first_name.toLowerCase();
                    if (fa > fb) {
                        return -1;
                    }
                    if (fa < fb) {
                        return 1;
                    }
                    return 0;
                });
            }else if (filter == 'dsc_last_name') {
                globDoctors.sort((a, b) => {
                    let fa = a.last_name.toLowerCase(),
                        fb = b.last_name.toLowerCase();
                    if (fa > fb) {
                        return -1;
                    }
                    if (fa < fb) {
                        return 1;
                    }
                    return 0;
                });
            }
            displaySortedAscDscDoctors(globDoctors)
        }
        // distplay asc/dsc sorted doctors 
        function displaySortedAscDscDoctors(doctors) {
            const docNamesContainer = document.getElementById('doc-names-alphabetically');
            docNamesContainer.innerHTML = '';
            if (doctors.length > 0) {
                const ul = document.createElement('ul');
                ul.class = 'sorting-li';
                // console.log(doctors.length)

                doctors.forEach(doctor => {
                    // console.log(doctor)
                    const a = document.createElement('a');
                    a.title = doctor.post_title;
                    a.textContent = doctor.post_title;
                    a.href = "/doctors/"+doctor.post_name;
                    const li = document.createElement('li');
                    // li.onclick = () => {
                    //     document.getElementById('searchInput').value = doctor.post_title;
                    //     suggestionsContainer.style.display = 'none';
                    // };
                    li.appendChild(a);
                    ul.appendChild(li);
                });
                docNamesContainer.appendChild(ul);
                docNamesContainer.style.display = 'block';
            } else {
                docNamesContainer.style.display = 'none';
            }

        }
        
    </script>
    <?php

    return ob_get_clean();
}
add_shortcode('doctor_search', 'doctor_search_shortcode');