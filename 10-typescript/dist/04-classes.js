"use strict";
// Enemy class
class Enemy {
    constructor(name, health) {
        this.name = name;
        this.health = health;
    }
    takeDamage(damage) {
        this.health -= damage;
    }
}
const pucca = new Enemy('Pucca', 200);
pucca.takeDamage(15);
pucca.takeDamage(15);
pucca.takeDamage(15);
pucca.takeDamage(15);
pucca.takeDamage(15);
const output04 = document.getElementById('output04');
if (output04) {
    output04.innerHTML = `
    <li><b>Enemy Name:</b> ${pucca.name}</li>
    <li><b>Total Health after 2 Attacks:</b> ${pucca.health}</li>
    `;
}
