(function( $ ) {
	'use strict';

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

                const url = `/kowaithospital/wp-json/fine_doc/api/search?q=${encodeURIComponent(input)}`;
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
                console.log(doctors)
                doctors.forEach(doctor => {
                    const li = document.createElement('li');
                    li.textContent = doctor.post_title;
                    li.onclick = () => {
                        document.getElementById('searchInput').value = doctor.post_title;
                        suggestionsContainer.style.display = 'none';
                    };
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
                console.log(symptoms)
                symptoms.forEach(symptom => {
                    const li = document.createElement('li');
                    li.textContent = symptom.name;
                    li.onclick = () => {
                        document.getElementById('searchInput').value = symptom.name;
                        suggestionsContainer.style.display = 'none';
                    };
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


        function getData($endPoint){
            const docNamesContainer = document.getElementById('doc-names-alphabetically');
            const docAlphaContainer = document.getElementById('doc-alphabets');
            docAlphaContainer.innerHTML = '';
            docNamesContainer.innerHTML = '';
            console.log($endPoint)
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if ($endPoint != 'get_doctors'){
                        displayData(response, $endPoint);
                    }else{
                        displayDoctors(response);
                    }
                } else {
                    console.error('Failed to fetch suggestions.');
                }
            }
            };

            const url = `/kowaithospital/wp-json/fine_doc/api/`+$endPoint;
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

            const docNamesContainer = document.getElementById('doc-names-alphabetically');
            const docAlphaContainer = document.getElementById('doc-alphabets');
            docAlphaContainer.innerHTML = '';

            let alpha_filter_ul = processAlphbeteFilter(tempCharectors, doctors);
            docAlphaContainer.appendChild(alpha_filter_ul);

            if (doctors.length > 0) {
                const ul = document.createElement('ul');
                ul.class = 'sorting-li';
                // const doctors = suggestions.doctors;
                console.log(doctors)
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
            console.log(charector)
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
            console.log(tempCharectors)
            const docNamesContainer = document.getElementById('doc-names-alphabetically');
            const docAlphaContainer = document.getElementById('doc-alphabets');
            docAlphaContainer.innerHTML = '';

            let alpha_filter_ul = processAlphbeteFilterForTaxonomy(tempCharectors, listOfTaxonomies);
            docAlphaContainer.appendChild(alpha_filter_ul);

            if (listOfTaxonomies.length > 0) {
                console.log(listOfTaxonomies)
                const ul = document.createElement('ul');
                ul.class = 'sorting-li';
                // const listOfTaxonomies = suggestions.listOfTaxonomies;
                console.log(listOfTaxonomies)
                listOfTaxonomies.forEach(taxonomy => {
                    const a = document.createElement('a');
                    // a.title = taxonomy.post_title;
                    a.textContent = taxonomy.name;
                    if ($endPoint == 'get_symptoms') {
                        a.href = "/symptom/"+taxonomy.slug;
                    }else{
                        a.href = "/personnel_category/"+taxonomy.slug;
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
            console.log(charector)
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

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready(function() {
		$('#FindDoctorFilter').click(function(event) {
			event.preventDefault(); // Prevent the default behavior of the anchor
			$('#filter-tab').toggleClass('show'); // Toggle the 'show' class of the div
		});
	});

})( jQuery );


