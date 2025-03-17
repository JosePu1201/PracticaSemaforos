class TrafficSimulation {
    constructor() {
        this.vehicles = [];
        this.queues = {
            north: [],
            south: [],
            east: [],
            west: []
        };
        this.isRunning = false;
        this.currentDirection = 'NORTH_SOUTH';
        this.timers = {
            northSouth: 30,
            eastWest: 30,
            yellow: 3
        };
        this.animations = [];
    }

    async loadVehicles(interseccionId) {
        try {
            const response = await fetch('../Controller/getVehiculos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `interseccionId=${interseccionId}`
            });
            const vehicles = await response.json();
            this.distributeVehicles(vehicles);
        } catch (error) {
            console.error('Error loading vehicles:', error);
        }
    }

    distributeVehicles(vehicles) {
        vehicles.forEach(vehicle => {
            switch(vehicle.direccion) {
                case 'N': this.queues.north.push(vehicle); break;
                case 'S': this.queues.south.push(vehicle); break;
                case 'E': this.queues.east.push(vehicle); break;
                case 'W': this.queues.west.push(vehicle); break;
            }
        });
        this.updateQueuesDisplay();
    }

    updateQueuesDisplay() {
        Object.keys(this.queues).forEach(direction => {
            const queueElement = document.getElementById(`queue-${direction}`);
            if (queueElement) {
                queueElement.innerHTML = this.queues[direction]
                    .map(vehicle => `
                        <div class="queue-vehicle" data-placa="${vehicle.placa}">
                            ${vehicle.tipo} - ${vehicle.placa}
                        </div>
                    `).join('');
            }
        });
    }

    async loadTimers(interseccionId) {
        try {
            const response = await fetch('../Controller/getSemaforos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `interseccionId=${interseccionId}`
            });
            const timers = await response.json();
            this.timers = {
                northSouth: parseInt(timers.tiempo_ns),
                eastWest: parseInt(timers.tiempo_eo),
                yellow: parseInt(timers.tiempo_amarillo)
            };
        } catch (error) {
            console.error('Error loading timers:', error);
        }
    }

    start() {
        if (this.isRunning) return;
        this.isRunning = true;
        this.runCycle();
    }

    stop() {
        this.isRunning = false;
        this.animations.forEach(animation => cancelAnimationFrame(animation));
        this.animations = [];
    }

    async runCycle() {
        while (this.isRunning) {
            // Norte-Sur verde
            await this.setLights('NORTH_SOUTH', 'green');
            await this.moveVehicles(['north', 'south'], this.timers.northSouth);
            
            // Amarillo
            await this.setLights('NORTH_SOUTH', 'yellow');
            await this.delay(this.timers.yellow * 1000);
            
            // Este-Oeste verde
            await this.setLights('EAST_WEST', 'green');
            await this.moveVehicles(['east', 'west'], this.timers.eastWest);
            
            // Amarillo
            await this.setLights('EAST_WEST', 'yellow');
            await this.delay(this.timers.yellow * 1000);
        }
    }

    async moveVehicles(directions, duration) {
        return new Promise(resolve => {
            const startTime = Date.now();
            const animate = () => {
                const elapsed = Date.now() - startTime;
                if (elapsed >= duration * 1000 || !this.isRunning) {
                    resolve();
                    return;
                }

                directions.forEach(direction => {
                    if (this.queues[direction].length > 0) {
                        const vehicle = this.queues[direction][0];
                        this.moveVehicle(vehicle, direction);
                    }
                });

                this.animations.push(requestAnimationFrame(animate));
            };
            animate();
        });
    }

    moveVehicle(vehicle, direction) {
        // Crear elemento del vehículo si no existe
        let vehicleElement = document.querySelector(`[data-placa="${vehicle.placa}"]`);
        if (!vehicleElement) {
            vehicleElement = document.createElement('div');
            vehicleElement.className = 'sim-vehicle';
            vehicleElement.dataset.placa = vehicle.placa;
            document.querySelector('.sim-intersection').appendChild(vehicleElement);
        }

        // Calcular nueva posición
        const positions = this.calculatePosition(direction);
        vehicleElement.style.left = positions.x + 'px';
        vehicleElement.style.top = positions.y + 'px';
    }

    calculatePosition(direction) {
        // Implementar lógica de posicionamiento según la dirección
        const positions = {
            north: { x: 250, y: -30 },
            south: { x: 250, y: 530 },
            east: { x: 530, y: 250 },
            west: { x: -30, y: 250 }
        };
        return positions[direction];
    }

    delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    setLights(direction, color) {
        // Implementar cambio de luces de semáforos
        const lights = document.querySelectorAll('.sim-bulb');
        lights.forEach(light => light.classList.remove('active'));

        if (direction === 'NORTH_SOUTH') {
            if (color === 'green') {
                document.querySelector('.sim-light-north .sim-bulb.sim-green').classList.add('active');
                document.querySelector('.sim-light-south .sim-bulb.sim-green').classList.add('active');
            } else if (color === 'yellow') {
                document.querySelector('.sim-light-north .sim-bulb.sim-yellow').classList.add('active');
                document.querySelector('.sim-light-south .sim-bulb.sim-yellow').classList.add('active');
            }
        } else {
            if (color === 'green') {
                document.querySelector('.sim-light-east .sim-bulb.sim-green').classList.add('active');
                document.querySelector('.sim-light-west .sim-bulb.sim-green').classList.add('active');
            } else if (color === 'yellow') {
                document.querySelector('.sim-light-east .sim-bulb.sim-yellow').classList.add('active');
                document.querySelector('.sim-light-west .sim-bulb.sim-yellow').classList.add('active');
            }
        }
    }
}