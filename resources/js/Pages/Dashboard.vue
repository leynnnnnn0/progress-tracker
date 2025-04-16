<script setup>
import OVPRE from "../../images/ovpre.png";
import MAINLOGO from "../../images/mainLogo.png";
import ATBI from "../../images/atbi.png";
import CCARD from "../../images/CCARD.png";
import COARDC from "../../images/COARDC.png";
import CSAC from "../../images/CSAC.png";
import FSRIC from "../../images/FSRIC.png";
import CRAC from "../../images/CRAC.png";
import GIS from "../../images/GIS.png";
import HERRC from "../../images/HERRC.png";
import IHFSA from "../../images/IHFSA.png";
import IPRO from "../../images/IPRO.png";
import ISRD from "../../images/ISRD.png";
import LAB from "../../images/LAB.png";
import REPO from "../../images/REPO.png";
import ORS from "../../images/ORS.png";
import OES from "../../images/OES.png";
import NPRCRTC from "../../images/NPRCRTC.png";
import BGC from "../../images/BGC.png";
import BKC from "../../images/BKC.png";

// Group all logos for easier management
const logos = [
    { src: ATBI, alt: "ATBI" },
    { src: CCARD, alt: "CCARD" },
    { src: COARDC, alt: "COARDC" },
    { src: CRAC, alt: "CRAC" },
    { src: CSAC, alt: "CSAC" },
    { src: FSRIC, alt: "FSRIC" },
    { src: GIS, alt: "GIS" },
    { src: HERRC, alt: "HERRC" },
    { src: IHFSA, alt: "IHFSA" },
    { src: IPRO, alt: "IPRO" },
    { src: ISRD, alt: "ISRD" },
    { src: LAB, alt: "LAB" },
    { src: NPRCRTC, alt: "NPRCRTC" },
    { src: OES, alt: "OES" },
    { src: ORS, alt: "ORS" },
    { src: REPO, alt: "REPO" },
    { src: BGC, alt: "BGC" },
    { src: BKC, alt: "BKC" },
];
</script>

<template>
    <MainLayout :isDashboard="true">
        <!-- Header section with main logos -->
        <div
            class="flex flex-col md:flex-row justify-between items-center w-full gap-6 px-4"
        >
            <img
                :src="MAINLOGO"
                alt="mainLogo"
                class="w-24 h-24 md:w-32 md:h-32"
            />

            <div class="flex flex-col text-center">
                <h1
                    aria-label="Benguet State University"
                    class="text-green-900 font-bold text-2xl sm:text-3xl md:text-4xl lg:text-5xl"
                >
                    BENGUET STATE UNIVERSITY
                </h1>
                <span
                    class="text-black font-bold text-sm sm:text-base md:text-lg lg:text-xl"
                >
                    OFFICE OF THE VICE PRESIDENT RESEARCH AND EXTENSION
                </span>
            </div>

            <img :src="OVPRE" alt="ovpre" class="w-24 h-24 md:w-32 md:h-32" />
        </div>

        <!-- Logo grid -->
        <div
            aria-label="Logos of research centers under the Vice President's office"
            class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6 lg:gap-10 mx-auto mt-8 md:mt-16 px-4"
        >
            <div
                v-for="(logo, index) in logos"
                :key="index"
                class="flex justify-center items-center"
            >
                <img
                    :src="logo.src"
                    :alt="logo.alt"
                    class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 lg:w-32 lg:h-32 object-contain"
                />
            </div>
        </div>
    </MainLayout>
</template>
