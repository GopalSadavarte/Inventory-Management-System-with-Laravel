import { closeErrorBox } from './primaryFormOperations.js'
import {
    reportOp,
    getWeekNumber,
    displayAppropriate,
    displayAll
} from './reportPrimary.js'
reportOp()

let fromDate = document.getElementById('fromDate')
let toDate = document.getElementById('toDate')
let searchBtn = document.getElementById('search-btn')
let expDates = document.querySelectorAll('.expiry-dates')
searchBtn.addEventListener('click', e => {
    e.preventDefault()
    let f = 0,
        f1 = 0
    if (fromDate.value == '') {
        alert('Please! select from value for search..')
        f = 1
    }

    if (toDate.value == '') {
        alert('Please! select to value date for search..')
        f1 = 1
    }
    // let num = getWeekNumber(new Date('2024-08-30'))
    // let v1 = fromDate.value.slice(6)
    // let v2 = toDate.value.slice(6)

    // console.log(typeof v1, typeof v2, typeof num)

    console.log(fromDate.value, toDate.value)

    if (f == 0 && f1 == 0) {
        displayAll()
        expDates.forEach(date => {
            let p = date.parentElement
            if (fromDate.value.includes('W')) {
                let num = getWeekNumber(new Date(date.textContent))
                let year = date.textContent.slice(0, 4)
                let v1 = parseInt(fromDate.value.slice(6))
                let v2 = parseInt(toDate.value.slice(6))
                let y1 = fromDate.value.slice(0, 4)
                let y2 = toDate.value.slice(0, 4)
                console.log(y1, y2, year)
                if (v1 <= num && v2 >= num && y1 <= year && y2 >= year)
                    p.classList.remove('d-none')
                else p.classList.add('d-none')
            } else if (fromDate.value.length == 7) {
                if (
                    date.textContent.slice(0, 7) >= fromDate.value &&
                    date.textContent.slice(0, 7) <= toDate.value
                )
                    p.classList.remove('d-none')
                else p.classList.add('d-none')
            } else {
                if (
                    date.textContent.slice(0, 4) >=
                        fromDate.value.slice(0, 4) &&
                    date.textContent.slice(0, 4) <= toDate.value.slice(0, 4)
                )
                    p.classList.remove('d-none')
                else p.classList.add('d-none')
            }
        })

        // let blockHeadings = document.querySelectorAll('.block-heading')
        displayAppropriate()
    }
})

// document.addEventListener('contextmenu', e => {
//     e.preventDefault()
// })
closeErrorBox()