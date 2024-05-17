<template>
  <div>
    <div id="map"></div>
    <div v-if="!isMobile" class="info">
      <p>Note: Geolocation accuracy may be lower on desktop devices. If the location is incorrect, please adjust it by dragging the marker.</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import L from 'leaflet';

export default {
  name: 'GarbageBinMap',
  props: {
    apiKey: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      isMobile: /iPhone|iPad|iPod|Android/i.test(navigator.userAgent),
      userMarker: null,
      map: null,
      userLocation: null,
      routeLine: null, // Track the current active route line
      binMarkers: new Map(), // Use a Map to store bin markers
    };
  },
  mounted() {
    this.initializeMap();
    this.fetchBinsAndUpdateRoutes();

    if (navigator.geolocation) {
      navigator.geolocation.watchPosition(
        (position) => {
          const lat = position.coords.latitude;
          const lon = position.coords.longitude;
          this.userLocation = [lat, lon];
          this.updateUserMarker([lat, lon]);
          this.map.setView([lat, lon], 13, { animate: false }); // Disable animations
          this.updateRoutes();
        },
        (error) => {
          console.error("Error getting user location:", error);
        },
        {
          enableHighAccuracy: true,
          timeout: 5000,
          maximumAge: 0,
        }
      );
    } else {
      console.error("Geolocation is not supported by this browser.");
    }
  },
  methods: {
    initializeMap() {
      this.map = L.map('map', { zoomAnimation: false }).setView([35.0116, 135.7681], 13); // Disable zoom animations

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
      }).addTo(this.map);
    },
    fetchBinsAndUpdateRoutes() {
      console.log("Fetching bins and updating routes"); // Debug log
      axios.get('/garbage-bins')
        .then(response => {
          const bins = response.data;
          console.log(`Fetched ${bins.length} bins`); // Debug log

          // Track existing marker keys
          const existingMarkers = new Set(this.binMarkers.keys());

          bins.forEach(bin => {
            const binId = `${bin.latitude}-${bin.longitude}`;
            if (!this.binMarkers.has(binId)) {
              console.log(`Adding marker for bin: ${binId}`); // Debug log
              const marker = L.marker([bin.latitude, bin.longitude]);
              marker.bindPopup(`<b>Garbage Bin</b><br>Type: ${bin.type}`);
              marker.on('click', () => {
                this.handleMarkerClick(binId, [bin.latitude, bin.longitude]);
              });
              this.binMarkers.set(binId, marker);
              marker.addTo(this.map);
            } else {
              // Remove the marker from the existing set since it still exists
              existingMarkers.delete(binId);
            }
          });

          // Debug log for existing markers after processing new bins
          console.log(`Existing markers after update: ${Array.from(existingMarkers)}`);

          // Remove markers that no longer exist
          existingMarkers.forEach(binId => {
            console.log(`Removing marker for bin: ${binId}`); // Debug log
            const marker = this.binMarkers.get(binId);
            if (this.map.hasLayer(marker)) {
              this.map.removeLayer(marker);
            }
            this.binMarkers.delete(binId);
          });

          // Final marker count
          console.log(`Final marker count: ${this.binMarkers.size}`);

          this.updateRoutes();
        })
        .catch(error => {
          console.error("There was an error fetching the garbage bin data:", error);
        });
    },
    handleMarkerClick(binId, latlng) {
      console.log(`Marker clicked: ${binId}`); // Debug log
      this.drawRoute(this.userLocation, latlng);
    },
    updateUserMarker(latlng) {
      if (this.userMarker) {
        this.userMarker.setLatLng(latlng);
      } else {
        console.log("Adding user marker"); // Debug log
        this.userMarker = L.marker(latlng, { draggable: true }).addTo(this.map);
        this.userMarker.bindPopup("<b>You are here!</b>").openPopup();

        // Add dragend event listener
        this.userMarker.on('dragend', (e) => {
          const { lat, lng } = e.target.getLatLng();
          this.userLocation = [lat, lng];
          this.updateRoutes();
        });
      }
    },
    drawRoute(start, end) {
      // Clear the existing route line
      if (this.routeLine && this.map.hasLayer(this.routeLine)) {
        this.map.removeLayer(this.routeLine);
      }

      const url = `https://api.openrouteservice.org/v2/directions/foot-walking?api_key=${this.apiKey}&start=${start[1]},${start[0]}&end=${end[1]},${end[0]}`;

      axios.get(url)
        .then(response => {
          const coordinates = response.data.features[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);
          this.routeLine = L.polyline(coordinates, { color: 'blue', dashArray: '4' });
          this.routeLine.addTo(this.map); // Store the current route line

          const distance = response.data.features[0].properties.segments[0].distance; // Distance in meters
          const duration = response.data.features[0].properties.segments[0].duration; // Duration in seconds

          const routeMarker = L.marker(end).addTo(this.map)
            .bindPopup(`<b>Garbage Bin</b><br>Distance: ${(distance / 1000).toFixed(2)} km<br>Walking time: ${(duration / 60).toFixed(2)} mins`)
            .openPopup();

          // Remove the route marker when the route line is removed
          this.routeLine.on('remove', () => {
            if (this.map.hasLayer(routeMarker)) {
              this.map.removeLayer(routeMarker);
            }
          });
        })
        .catch(error => {
          console.error('Error fetching route data:', error);
        });
    },
    updateRoutes() {
      if (!this.userLocation || this.binMarkers.size === 0) {
        return;
      }

      // Find the nearest bin
      let nearestBin = null;
      let shortestDistance = Infinity;

      this.binMarkers.forEach((marker, key) => {
        const binLatLng = marker.getLatLng();
        const distance = this.map.distance(this.userLocation, binLatLng);
        if (distance < shortestDistance) {
          shortestDistance = distance;
          nearestBin = binLatLng;
        }
      });

      if (nearestBin) {
        this.drawRoute(this.userLocation, [nearestBin.lat, nearestBin.lng]);
      }
    }
  }
};
</script>

<style scoped>
#map {
  height: 600px;
}
.info {
  margin-top: 10px;
  color: red;
}
</style>
